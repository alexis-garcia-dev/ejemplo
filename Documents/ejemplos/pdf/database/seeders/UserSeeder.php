<?php

use Illuminate\Database\Seeder;
use App\Models\User;
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
        // Crear 20 usuarios al azar
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $this->generateRandomName(),
                'email' => $this->generateRandomEmail(),
                'password' => Hash::make('password123'), // Puedes cambiar la contraseña según sea necesario
            ]);
        }
    }

    /**
     * Genera un nombre aleatorio.
     *
     * @return string
     */
    private function generateRandomName()
    {
        $names = ['John Doe', 'Jane Smith', 'Michael Johnson', 'Emily Davis', 'Daniel Brown', 'Jessica Miller'];
        return $names[array_rand($names)];
    }

    /**
     * Genera un correo electrónico aleatorio.
     *
     * @return string
     */
    private function generateRandomEmail()
    {
        $domains = ['example.com', 'gmail.com', 'yahoo.com', 'outlook.com', 'domain.com'];
        $name = str_replace(' ', '', strtolower($this->generateRandomName()));
        return $name . '@' . $domains[array_rand($domains)];
    }
}
