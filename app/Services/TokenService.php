<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Token;

class TokenService
{
    public function getNextToken($doctorId, $appointmentDate, $appointmenId)
    {
        $existingAppointmentsCount = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $appointmentDate)
            ->count();

        if ($existingAppointmentsCount > 0) {
            $nextToken = Token::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $appointmentDate)
                ->max('token') + 1;
        } else {
            $nextToken = 1;
        }
        $this->saveToken($doctorId, $appointmentDate, $nextToken, $appointmenId);

        return $nextToken;
    }

    private function saveToken($doctorId, $appointmentDate, $token, $appointmenId)
    {
        Token::create([
            'doctor_id' => $doctorId,
            'appointment_id' => $appointmenId,
            'token' => $token,
            'appointment_date' => $appointmentDate
        ]);
    }
}
