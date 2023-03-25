<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\Models\User;
        $administrator->email = "administrator@online-class.test";
        $administrator->password = \Hash::make("12345");
        $administrator->name = "Application Administrator";
        $administrator->level = "admin";
        $administrator->gender = "pria";
        $administrator->avatar = "none.png";
        $administrator->address = "sidoarjo";
        $administrator->phone = "082332224932";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }   
}
