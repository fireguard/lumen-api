<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Ronaldo Meneguite',
            'email' => 'suporte@fireguard.com.br',
            'password' => bcrypt('Suporte+2017'),
            'function' => 'Administrador'
        ]);

        factory(App\Models\User::class, 50)->create();
    }
}
