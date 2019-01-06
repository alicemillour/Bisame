<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlternativeWord;
use App\Traits\Badgeable;
use Log;
class AlternativeWordController extends Controller
{

    use Badgeable;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug("dans la fonction store");
    	// Existing translation ?
    	$translation = AlternativeWord::where([
                'original' => $request->input('original'),
    		'alternative' => $request->input('alternative'),
            ])->first();

    	if($translation) {
                // si la variante existe déjà, ne rien faire
    	} else {
                // sinon on crée une nouvelle entrée
                Log::debug("create translation");
                Log::debug($request->input('original'));
                Log::debug($request->input('alternative'));
        	$translation = AlternativeWord::create(array_merge(array(
                'user_id'=>auth()->user()->id,
                'alternative' => $request->input('alternative'),
                'original' => $request->input('original')
            )));
    	}
        Log::debug($translation);
        $this->checkBadge($request, 'alternativ-word', auth()->user()->getNbAlternative());
        Log::debug("on va rediriger");
//        return($toto);
//         return redirect('')->with('success','Write here your messege');
        redirect()->route('home'); 
//        return redirect('words/' . $request->input('word_id'))->withSuccess(__('recipes.created'));
    }
}
