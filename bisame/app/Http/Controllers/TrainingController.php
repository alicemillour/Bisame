<?php 

namespace App\Http\Controllers;

use App\Repositories\TrainingRepository;
use App\Repositories\AnnotationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TrainingController extends GameController {

  protected $trainingRepository;

  public function __construct(TrainingRepository $trainingRepository, AnnotationRepository $annotationRepository)
  {
      $this->annotationRepository = $annotationRepository;
      $this->trainingRepository = $trainingRepository;
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
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
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
}

?>