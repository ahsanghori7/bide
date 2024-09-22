<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('organizations')->truncate();
        DB::table('roles')->truncate();
        DB::table('clinics')->truncate();
        DB::table('users')->truncate();
        DB::table('clinic_user')->truncate();
        DB::table('ethnicities')->truncate();
        DB::table('medicine_routes')->truncate();
        DB::table('medicine_generics')->truncate();
        DB::table('medicine_strengths')->truncate();
        DB::table('insulin_units')->truncate();
        DB::table('specialities')->truncate();
        DB::table('universities')->truncate();
        DB::table('medicine_types')->truncate();
        DB::table('occupations')->truncate();
        DB::table('lifestyles')->truncate();

        Artisan::call('db:seed', ['--class' => 'OrganizationsSeeder']);
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'ClinicsSeeder']);
        Artisan::call('db:seed', ['--class' => 'UsersSeeder']);
        Artisan::call('db:seed', ['--class' => 'ClinicUserSeeder']);
        Artisan::call('db:seed', ['--class' => 'EthnicitiesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'QuestionsSeeder']);
        Artisan::call('db:seed', ['--class' => 'RouteSeeder']);
        Artisan::call('db:seed', ['--class' => 'GenericSeeder']);
        Artisan::call('db:seed', ['--class' => 'StrengthSeeder']);
        Artisan::call('db:seed', ['--class' => 'InsulinSeeder']);
        Artisan::call('db:seed', ['--class' => 'UniversitiesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'SpecialitiesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'MealTimeSeeder']);
        Artisan::call('db:seed', ['--class' => 'EmailNotificationsSeeder']);
        Artisan::call('db:seed', ['--class' => 'MedicineTypesSeeder']);
        Artisan::call('db:seed', ['--class' => 'LifestyleSeeder']);
        Artisan::call('db:seed', ['--class' => 'OccupationSeeder']);
    }
}
