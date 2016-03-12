<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
	{
		DB::table('users')->delete();

		for($i = 0; $i < 10; ++$i)
		{
			DB::table('users')->insert([
				'name' => 'Nom' . $i,
				'email' => 'email' . $i . '@blop.fr',
				'password' => bcrypt('password'),
				'admin' => rand(0, 1)
			]);
		}
		DB::table('users')->insert([
                                'name' => 'alice' . $i,
                                'email' => 'alice.millour' . $i . '@abtela.eu',
                                'password' => bcrypt('password'),
                                'admin' => '1'
			]);
	}
}
