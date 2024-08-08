<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = ['antonio', 'stanislav', 'emanuel', 'carlo', 'andrea', 'luca', 'fabio', 'francesco', 'simone', 'pierpaolo'];

        $email = ['risto1@test.com', 'risto2@test.com', 'risto3@test.com', 'risto4@test.com', 'risto5@test.com', 'risto6@test.com', 'risto7@test.com', 'risto8@test.com', 'risto9@test.com', 'risto10@test.com'];

        for ($i = 0; $i < 10; $i++) {
            $newUser = new User();
            $newUser->name = $name[$i];
            $newUser->email = $email[$i];
            $newUser->password = bcrypt('password');
            $newUser->save();
        }
    }
}
