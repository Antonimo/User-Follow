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
        

        $groups = [];

        foreach (range(0, 5) as $number) {
            $groups[] = [
                'name' => str_random(10)
            ];
        }

        DB::table('groups')->insert($groups);




        $users = [];

        foreach (range(0, 12) as $number) {
            $users[] = [
	            'name' => str_random(10),
	            'email' => str_random(10).'@gmail.com',
	            'password' => bcrypt('secret'),
                
                'group_id' => rand(1, 5)
	        ];
        }

        DB::table('users')->insert($users);
    }
}
