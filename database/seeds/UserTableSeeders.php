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
//		for($i = 0; $i < 10; ++$i)
//		{
//			DB::table('users')->insert([
//				'name' => 'Nom' . $i,
//				'email' => 'email' . $i . '@blop.fr',
//				'password' => bcrypt('password'),
//				'is_admin' => false
//			]);
//		}
        # recalculate confidence_score for all users 
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $number_annotated_words_on_reference = $this->annotationRepository->get_number_annotations_on_reference($user->id)->count;
            $number_correct_annotations_on_reference = $this->annotationRepository->get_number_correct_annotations_on_reference($user->id)->count;
            if ($number_annotated_words_on_reference != 0) {
                $new_confidence_score = $number_correct_annotations_on_reference / $number_annotated_words_on_reference;
                DB::table('users')->where('users.id', $user->id)->update(['score' => $new_confidence_score]);
            }
        }
//            DB::table('users')->insert([
//                            'name' => 'Gamer',
//                            'email' => 'test@gamer.bisame',
//                            'password' => bcrypt('g@m3rB3'),
//                            'is_admin' => true,
//                            'is_in_training' => false
//            ]);
        }
    }
    