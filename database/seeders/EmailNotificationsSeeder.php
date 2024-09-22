<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_notifications')->insert([
            'organization_id' => 1,
            'template_reference' => 'otp',
            'template_path' => 'email_templates.otp',
            'subject' => 'Your Login OTP',
            'body' => "Dear {name}, </br></br> Your One-Time Password (OTP) for login is: ^{otp}.</br>This OTP is valid for 1 minutes.</br> Please enter it on the login page to proceed.</br>
            If you didn't request this OTP, please contact your admin immediately.</br></br>
            Best regards,</br>
            Meri Sehat",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
