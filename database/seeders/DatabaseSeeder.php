<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = include(storage_path('app/public/users.php'));
        $offices = include(storage_path('app/public/offices.php'));
        
        foreach ($users AS $user) {
            User::create([
                'biometrics_id' => $user['biometrics_id'],
                'avatar' => $user['avatar'],
                'code' => $user['code'],
                'name' => $user['name'],
                'nickname' => $user['nickname'],
                'address' => $user['address'],
                'contact_number' => $user['contact_number'],
                'email' => $user['email'],
                'position' => $user['position'],
                'birthdate' => $user['birthdate'],
                'sex' => $user['sex'],
                'blood_type' => $user['blood_type'],
                'gsis_number' => $user['gsis_number'],
                'pagibig_number' => $user['pagibig_number'],
                'philhealth_number' => $user['philhealth_number'],
                'tin_number' => $user['tin_number'],
                'emergency_contact_name' => $user['emergency_contact_name'],
                'emergency_contact_number' => $user['emergency_contact_number'],
                'contract_from' => $user['contract_from'],
                'contract_to' => $user['contract_to'],
                'username' => $user['username'],
                'password' => $user['password'],
            ]);
        }
        
        foreach ($offices AS $office) {
            Office::create([
                'name' => $office['name'],
                'short_name' => $office['short_name'],
                'parent_id' => $office['parent_id'],
            ]);
        }
    }
}
