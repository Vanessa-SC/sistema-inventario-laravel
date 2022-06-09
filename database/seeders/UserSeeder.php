<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'vanessa-sifuentes',
            'nombre' => 'Vanessa Sifuentes',
            'password' => bcrypt('12345678')
        ])->assignRole('Admin');

        Image::factory(1)->create([
                'imageable_id' => $user->id,
                'imageable_type' => User::class
        ]);
        
        $users = User::factory(9)->create();

        foreach ($users as $user){
            Image::factory(1)->create([
                'imageable_id' => $user->id,
                'imageable_type' => User::class
            ]);
            $user->assignRole('Cajero');
        }
    }
}
