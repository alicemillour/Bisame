<?php 

namespace App\Http\Controllers;

use App\Repositories\TrainingRepository;
use App\Repositories\AnnotationRepository;
use App\Repositories\PostagRepository;
use App\Repositories\SentenceRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB; 

class TrainingController extends GameController {

  protected $trainingRepository;

  public function __construct(TrainingRepository $trainingRepository, 
          AnnotationRepository $annotationRepository, PostagRepository $postagRepository, 
          SentenceRepository $sentenceRepository, UserRepository $userRepository)
  {
      $this->annotationRepository = $annotationRepository;
      $this->trainingRepository = $trainingRepository;
      $this->postagRepository = $postagRepository;
      $this->sentenceRepository = $sentenceRepository;
      $this->userRepository = $userRepository;
      $this->middleware('auth');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $game = $this->get_or_create_game();
      return Redirect::route('training.show', ['id' => $game->id]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $repository = $this->get_game_repository();
    $game = $repository->getById($id);
    $this->authorize($game);
    if ($request->input('annotations')) {
        $sentence = $game->sentences[$game->sentence_index];
        $answers_hash = $this->check_annotations($request->input('annotations'), $sentence);
        if ($answers_hash["everything_is_correct"]) {
          return $this->get_next_sentence_or_finish($game);
        } else {
          return $answers_hash['answers'];
        }
    } else {
      return [];
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
  protected function get_game_repository()
  {
      return $this->trainingRepository;
  }

  private function get_next_sentence_or_finish($game)
  {
    $new_index = $game->sentence_index + 1;
    $progression= ($new_index + 1)*100/4;
    if ($new_index >= $game->sentences->count()) {
      $game->is_finished = true;
      $current_user = Auth::user();
      $current_user->is_in_training = false;
      if ($this->userRepository->get_level_by_id($current_user->id) === 0){
        DB::table('users')->where('id', '=', $current_user->id)->increment('level', 1);
      }
      $current_user->is_in_training = false;
      $current_user->save();
      $game->save();
      return;
   } else {
      $game->sentence_index = $new_index;
      $game->save();
      $sentence = $game->sentences[$new_index];
      $game_everything_is_annotated = false;
      $pretag=null;
      return view('games.sentence', compact('sentence','game','game_everything_is_annotated','progression','pretag'));
    }
  }
}