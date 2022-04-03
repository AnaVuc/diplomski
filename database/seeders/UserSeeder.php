<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
            'firstName' => 'Ana',
            'lastName' => 'Vuceljic',
            'username'=>"ana.vuceljic",
            'email' => 'ana.vuceljic@mail.com',
            'password' => Hash::make('AnaVuceljic123'),
            'role_id' => 3
            ],
            [
            'firstName' => 'Marko',
            'lastName' => 'Markovic',
            'username'=>"marko.markovic",
            'email' => 'marko.markovic@mail.com',
            'password' => Hash::make('MarkoMarkovic123'),
            'role_id' => 3

            ],
            [
            'firstName' => 'Pera',
            'lastName' => 'Peric',
            'username'=>"pera.peric",
            'email' => 'pera.peric@mail.com',
            'password' => Hash::make('PeraPeric123'),
            'role_id' => 3

            ],
            [
            'firstName' => 'Jovana',
            'lastName' => 'Ivanovic',
            'username'=>"jovana.ivanovic",
            'email' => 'jovana.ivanovic@mail.com',
            'password' => Hash::make('JovanaIvanovic123'),
            'role_id' => 3
            ],
            [
            'firstName' => 'Emilija',
            'lastName' => 'Radovanovic',
            'username'=>"emilija.radovanovic",
            'email' => 'emilija.radovanovic@mail.com',
            'password' => Hash::make('EmilijaRadovanovic123'),
            'role_id' => 3
            ],
            [
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'username'=>"admin",
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1
            ],
            [
            'firstName' => 'Moderator',
            'lastName' => 'Moderator',
            'username'=>"moderator",
            'email' => 'moderator@mail.com',
            'password' => Hash::make('moderator123'),
            'role_id' => 2
            ],
        ];

        User::insert($data);
    }
}
