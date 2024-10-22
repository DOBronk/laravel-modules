<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Roles;
use App\Models\Message;

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
        // Create user roles
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

        // Create users
        $admin = User::create([
            'name' => 'Dennis Admin',
            'email' => 'test@bronk.nl',
            'dob' => '1989/12/1',
            'phone' => '0687654321',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $studentA = User::create([
            'name' => 'Alpha Student',
            'email' => 'studenta@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $studentB = User::create([
            'name' => 'Beta Student',
            'email' => 'studentb@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $studentC = User::create([
            'name' => 'Charlie Student',
            'email' => 'studentc@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $studentD = User::create([
            'name' => 'Delta Student',
            'email' => 'studentd@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $studentE = User::create([
            'name' => 'Echo Student',
            'email' => 'studente@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $mentorA = User::create([
            'name' => 'Alpha Mentor',
            'email' => 'mentora@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $mentorB = User::create([
            'name' => 'Beta Mentor',
            'email' => 'mentorb@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $parentAX = User::create([
            'name' => 'Alpha X-Ray',
            'email' => 'ouderax@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $parentBX = User::create([
            'name' => 'Beta X-Ray',
            'email' => 'ouderbx@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $parentAY = User::create([
            'name' => 'Alpha Yankee',
            'email' => 'ouderay@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $parentBY = User::create([
            'name' => 'Beta Yankee',
            'email' => 'ouderby@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        $parentAZ = User::create([
            'name' => 'Alpha Zulu',
            'email' => 'ouderaz@bronk.nl',
            'dob' => '1989/12/01',
            'phone' => '06876543231',
            'email_verified_at' => now(),
            'password' => Hash::make('wachtwoord')
        ]);

        // Create schoolclasses
        $class1A = Classroom::create([
            'name' => '1A',
            'year' => '1',
            'mentor_id' => $mentorB->id,
        ]);

        $class1B = Classroom::create([
            'name' => '1B',
            'year' => '1',
            'mentor_id' => $admin->id,
        ]);

        $class2A = Classroom::create([
            'name' => '2A',
            'year' => '2',
            'mentor_id' => $mentorA->id,
        ]);

        // Generate a welcome message for every user
        $users = User::all();

        foreach ($users as $user) {
            Message::create([
                'user_id' => $user->id,
                'from_user_id' => $admin->id,
                'read' => 0,
                'subject' => 'Welkom',
                'message' => "Hallo $user->name,\n\nWelkom op het studentmanager platform!\n\nMet vriendelijke groet,\n$admin->name",
            ]);
        }

        // Attach roles to users
        $admin->roles()->attach($adid);
        $admin->roles()->attach($mid);

        $studentA->roles()->sync($sid);
        $studentB->roles()->sync($sid);
        $studentC->roles()->sync($sid);
        $studentD->roles()->sync($sid);
        $studentE->roles()->sync($sid);

        $mentorA->roles()->sync($mid);
        $mentorB->roles()->sync($mid);

        $parentAX->roles()->sync($pid);
        $parentBX->roles()->sync($pid);
        $parentAY->roles()->sync($pid);
        $parentBY->roles()->sync($pid);
        $parentAZ->roles()->sync($pid);

        // Attach student users to parent users
        $parentAX->children()->attach($studentA);
        $parentAX->children()->attach($studentB);
        $parentBX->children()->attach($studentA);
        $parentBX->children()->attach($studentB);

        $parentAY->children()->attach($studentD);
        $parentAY->children()->attach($studentE);
        $parentBY->children()->attach($studentD);
        $parentBY->children()->attach($studentE);

        $parentAZ->children()->attach($studentC);

        // Attach students to schoolclasses
        $class1A->students()->attach($studentA);
        $class1A->students()->attach($studentB);
        $class1B->students()->attach($studentC);
        $class2A->students()->attach($studentD);
        $class2A->students()->attach($studentE);
    }
}
