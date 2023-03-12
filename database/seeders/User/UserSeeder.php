<?php

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            User::create([
                'name'     => 'jay',
                'email'    => 'test@gmail.com',
                'password' => Hash::make('password')
            ]);
        } catch (\Exception $e) {
            report($e);
            $this->command->error($e->getMessage());
            return;
        }

        $this->command->info('User created successfully!');
    }
}
