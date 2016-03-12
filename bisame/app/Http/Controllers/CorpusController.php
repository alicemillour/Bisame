<?php 

namespace App\Http\Controllers;

use App\Repositories\CorpusRepository;

class CorpusController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  protected $corpusRepository;

  public function __construct(CorpusRepository $corpusRepository)
  {
    $this->corpusRepository = $corpusRepository;
  }

  public function index()
  {
    $corpora = $this->corpusRepository->getAndPaginate(20);
    $links = $corpora->setPath('')->render();

    return view('corpora.liste', compact('corpora', 'links'));
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
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
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
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
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
  
}

?>