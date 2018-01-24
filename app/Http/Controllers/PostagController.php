<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Postag;
use App\Repositories\PostagRepository;

class PostagController extends Controller
{
    protected $postagRepository;

    public function __construct(PostagRepository $postagRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['getByWord']);
        $this->postagRepository = $postagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByWord()
    {
        $word_id = $_GET['word_id'];
        debug($word_id);
        $postags = $this->postagRepository->getPostagsForWordId($word_id);
        /* -1 because of punct tag not displayed */
        return ['postags' => $postags,
                'all_categories' => $this->postagRepository->count()-1 == count($postags)];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('postags.index', [
            'postags' => Postag::orderBy('order')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Postag $postag)
    {
        return view('postags.show', compact('postag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Postag $postag)
    {
        return view('postags.edit', compact('postag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Postag $postag)
    {
        $postag->update($request->all());
        return redirect('postag')->withSuccess("Le postag a été mis à jour");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
