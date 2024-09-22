<?php

namespace App\Console\Commands;

use App\Http\Common\Constant;
use App\Models\Appointment;
use App\Models\DoctorQueue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update appointments where call continue has passed 10 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $time = now()->subMinutes(10);
            $cancelledAppointments = Appointment::where('call_started', '<', $time)
                ->where('status', Constant::APPOINTMENT_STATUS_PROGRESS)
                ->pluck('id');
            Appointment::whereIn('id', $cancelledAppointments)->update(
                [
                    'call_ended' => Carbon::now(),
                    'agora_link' => null,
                    'is_patient_connected' => 0,
                    'is_doctor_connected' => 0,
                    'cancelled_by' => 'system',
                    'status' => Constant::APPOINTMENT_STATUS_CANCELLED
                ]
            );
            User::whereHas('appointments', function ($query) use ($cancelledAppointments) {
                $query->whereIn('id', $cancelledAppointments);
            })->update(['in_call' => 0]);

            DoctorQueue::whereIn('appointment_id', $cancelledAppointments)
                ->where('status', Constant::QUEUE_STATUS_PROGRESS)->update([
                    'status' => Constant::QUEUE_STATUS_CANCELLED,
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        $this->info('Appointments cancelled successfully.');
    }
}
