<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call('UserTableSeeder');
        $this->call('PostagTableSeeder');
        $this->call('CorpusTableSeeder');
        $this->call('WordTableSeeder');
        $this->call('AnnotationTableSeeder');
        $this->call('BadgesTableSeeder');
        $this->call('AgeGroupsTableSeeder');

        // Roles
        $role_admin = Role::firstOrCreate(['slug' => Role::ROLE_ADMIN]);
        Role::firstOrCreate(['slug' => Role::ROLE_MODERATOR]);   
        // Users
        // if (! User::where('email', 'admin@admin.com')->exists()) {
        //     $user = User::create([
        //         'name' => 'admin',
        //         'email' => 'admin@admin.com',
        //         'password' => '4dm1n',
        //         'is_admin' => '1',
        //     ]);
        //     // $user->roles()->attach($role_admin->id);
        // }

    Model::reguard();

    }
}