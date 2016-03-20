<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Repositories\GameRepository;
use Illuminate\Support\Facades\Redirect;


class GameController extends Controller
{

	protected $gameRepository;

    public function __construct(GameRepository $gameRepository)
	{
		$this->gameRepository = $gameRepository;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$current_user = Auth::user();
		$game = $this->gameRepository->store(['user_id' => $current_user->id]);

		return Redirect::route('games.edit', ['id' => $game->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$game = $this->gameRepository->getById($id);
    	$sentence = $game->sentences[1];
        return view('games.edit', compact('sentence'));
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
        //
    }

}
