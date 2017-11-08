<?php

use Illuminate\Database\Seeder;
use App\Repositories\AnnotationRepository;

class UserTableSeeder extends Seeder {
    protected $annotationRepository;

    public function __construct(AnnotationRepository $annotationRepository) {
        $this->annotationRepository = $annotationRepository;
    }

    public function run() {
        // Uncomment the below to wipe the table clean before populating
//            DB::table('users')->delete();   
            DB::table('users')->insert([
                            'name' => 'Admin',
                            'email' => 'admin@game.bisame',
                            'password' => bcrypt('My@dM1nB3'),
                            'is_admin' => true,
                            'is_in_training' => false
            ]);
        }
    }
    