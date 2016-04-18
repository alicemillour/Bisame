<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {


    public function run()
	{
            // Uncomment the below to wipe the table clean before populating
            DB::table('users')->delete();   
//		for($i = 0; $i < 10; ++$i)
//		{
//			DB::table('users')->insert([
//				'name' => 'Nom' . $i,
//				'email' => 'email' . $i . '@blop.fr',
//				'password' => bcrypt('password'),
//				'is_admin' => false
//			]);
//		}
            DB::table('users')->insert([
                            'name' => 'Admin',
                            'email' => 'alice.millour@abtela.eu',
                            'password' => bcrypt('B!$@m3'),
                            'is_admin' => true
            ]);
            DB::table('users')->insert([
                            'name' => 'Gamer',
                            'email' => 'test@gamer.bisame',
                            'password' => bcrypt('g@m3rB3'),
                            'is_admin' => true,
                            'is_in_training' => false
            ]);
	}
}
