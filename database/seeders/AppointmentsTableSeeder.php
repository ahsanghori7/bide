<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointmentsData = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'clinic_id' => 1,
                'user_agent' => 'Web Browser',
                'booked_via_subscription' => 'Yes',
                'subscription_id' => 123,
                'is_patient_connected' => 1,
                'user_id' => 1,
                'family_member_id' => null,
                'consultation_fee' => 50,
                'reason' => 'General Checkup',
                'type' => 'In-person',
                'priority' => 'medium',
                'date' => '2024-03-01',
                'time' => '10:00:00',
                // Add other fields as needed
            ]
        ];

        foreach ($appointmentsData as $appointmentData) {
            Appointment::create($appointmentData);
        }
    }
}
