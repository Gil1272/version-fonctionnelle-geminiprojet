<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'DIMON Shadrac',
            'email'    => 'shadrac@gmail.com',
            'password' => Hash::make('Sh@dy123'), // Hash du mot de passe
        ]);
    }
}
