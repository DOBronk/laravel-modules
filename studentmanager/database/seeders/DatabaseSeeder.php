<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schoolclass;
use App\Models\Roles;

use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $sid = Roles::create([
            'name' => 'ROLE_STUDENT',
            'description' => 'Student',
        ]);
        $mid = Roles::create([
            'name' => 'ROLE_MENTOR',
            'description' => 'Mentor',
        ]);
        $pid = Roles::create([
            'name' => 'ROLE_PARENT',
            'description' => 'Parent',
        ]);
        $adid = Roles::create([
            'name' => 'ROLE_ADMIN',
            'description' => 'Administrator',
        ]);

        $admin = User::create([
            'name' => 'Dennis Administrator',
            'email' => 'test@bronk.nl',
            'dob' => '1989/12/1',
            'phone' => '0687654321',
            'password' => Hash::make('wachtwoord')
        ]);

        $student0 = User::create([
            'name' => 'Test Student',
            'email' => 'student@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'password' => Hash::make('wachtwoord')
        ]);

        $student1 = User::create([
            'name' => 'Andere Student',
            'email' => 'anders@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'password' => Hash::make('wachtwoord')
        ]);

        $mentor = User::create([
            'name' => 'Test Mentor',
            'email' => 'mentor@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'password' => Hash::make('wachtwoord')
        ]);

        $parent = User::create([
            'name' => 'Test Ouder',
            'email' => 'ouder@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'password' => Hash::make('wachtwoord')
        ]);

        $class = Schoolclass::create([
            'name' => '1A',
            'year' => '1',
            'mentor_id' => $mentor->id,
        ]);

        $admin->roles()->sync($adid);
        //   $admin->mentors()->attach($class);
        //   $admin->parents()->attach($parent);
        $student0->roles()->sync($sid);
        $student1->roles()->sync($sid);
        $mentor->roles()->sync($mid);
        $parent->roles()->sync($pid);
        $students = $class->students();
        $students->attach($student1);
        $students->attach($student0);
    }
}
