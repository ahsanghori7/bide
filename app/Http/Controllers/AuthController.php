<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\ApiResponse;
use App\Jobs\SendOtpJob;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $email = $request->input('email');
                    $user = User::where('email', $email)->first();
                    if (!$user || $user->role_id != $value) {
                        $fail("The selected role is invalid for the given email.");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ApiResponse::error(trans('errors.email_not_found'), 422);
        }

        $otp = env('APP_ENV') != 'production' ? '0000' : str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $user->update([
            'otp' => $otp,
            'otp_expire' => Carbon::now()->addMinutes(1),
            'network' => strtolower($request->network),
            'platform' => $request->header('platform') ? $request->header('platform') : 'web'
        ]);

        if (env('APP_ENV') == 'production') {
            SendOtpJob::dispatch($user);
        }

        return ApiResponse::success();
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The email field is required.',
            'email.exists' => 'The selected email is invalid.',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(trans('errors.email_not_found'), 422);
        }

        $user = User::where('email', $request->email)->first();

        $otp = config('app.env') !== 'production' ? '0000' : str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $user->update([
            'otp' => $otp,
            'otp_expire' => Carbon::now()->addMinutes(1),
        ]);

        return ApiResponse::success();
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->update([
                'is_login' => 0,
            ]);
            $request->user()->token()->revoke();

            return ApiResponse::success('Logout successful');
        } catch (\Exception $e) {
            return ApiResponse::error(trans('errors.invalidate_token'), 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required'
        ], [
            'email.required' => trans('errors.email_required'),
            'email.exists' => trans('errors.email_not_found'),
            'otp.required' => trans('errors.required_otp'),
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $user = User::where('email', $request->email)->first();

        $timeToCheck = Carbon::createFromTimeString($user->otp_expire);

        if ($user->otp_expire && Carbon::now()->gt($timeToCheck)) {
            return ApiResponse::error(trans('errors.otp_expired'), 401);
        }

        if ($user->otp !== $request->otp) {
            return ApiResponse::error(trans('errors.invalid_otp'), 401);
        }

        $user->update(['is_login' => true, 'last_login' => Carbon::now()]);
        if ($user->role_id == 2) {
            $user->tokens()->delete();
        }
        return new LoginResource($user);
    }

    public function userInfo(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }
}
