<?php

use Illuminate\Database\Seeder;
use App\Repositories\AnnotationRepository;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder {
    protected $annotationRepository;

    public function __construct(AnnotationRepository $annotationRepository) {
        $this->annotationRepository = $annotationRepository;
    }

    public function run() {
        // Uncomment the below to wipe the table clean before populating
//            DB::table('users')->delete();   
        $role_admin = Role::firstOrCreate(['slug' => Role::ROLE_ADMIN]);
        Role::firstOrCreate(['slug' => Role::ROLE_MODERATOR]);        
        if (! User::where('email', 'admin@game.bisame')->exists()) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@game.bisame',
                'password' => 'My@dM1nB3',
                'is_admin' => true,
                'is_in_training' => false
            ]);
            $user->roles()->attach($role_admin->id);
        }
    }

}
    