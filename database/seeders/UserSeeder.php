<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;
use Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'jozo',
            'email' => 'jozo@gmail.com',
            'password' => Hash::make('jozo'),
            'role' => 2,
            'password_changed' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
