<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;

class LikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['create','store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $like = Like::firstOrCreate([
                'likeable_id' => $request->input('likeable_id'),
                'likeable_type' => $request->input('likeable_type'),
                'user_id'=>auth()->user()->id,
            ]);
        $count = Like::where('likeable_id',$request->input('likeable_id'))
                ->where('likeable_type',$request->input('likeable_type'))
                ->count();
        return response()->json(['likes_count'=>$count]);
    }
}
