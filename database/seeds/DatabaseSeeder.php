<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Bob Smith',
            'email' => 'bsmith@gmail.com',
            'password' => bcrypt('Password'),
        ]);
		
		DB::table('users')->insert([
            'name' => 'John Smith',
            'email' => 'jsmith@gmail.com',
            'password' => bcrypt('Password'),
        ]);
		
		DB::table('users')->insert([
            'name' => 'Patty Smith',
            'email' => 'psmith@gmail.com',
            'password' => bcrypt('Password'),
        ]);
		
		DB::table('friendships')->insert([
            'user_id' => '1',
            'friend_id' => '2',
        ]);
		
		DB::table('friendships')->insert([
            'user_id' => '1',
            'friend_id' => '3',
        ]);
		
		DB::table('friendships')->insert([
            'user_id' => '2',
            'friend_id' => '1',
        ]);
		
		DB::table('friendships')->insert([
            'user_id' => '3',
            'friend_id' => '2',
        ]);
		
		DB::table('friendships')->insert([
            'user_id' => '2',
            'friend_id' => '3',
        ]);
		
    }
}
