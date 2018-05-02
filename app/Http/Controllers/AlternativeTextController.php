<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlternativeText;
use App\Traits\Badgeable;

class AlternativeTextController extends Controller
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
    	// Existing translation ?
    	$translation = AlternativeText::where([
    			'translatable_id' => $request->input('translatable_id'),
    			'translatable_type' => $request->input('translatable_type'),
    			'translatable_attribute' => $request->input('translatable_attribute'),
    			'offset_start' => $request->input('offset_start'),
    			'offset_end' => $request->input('offset_end'),
                'user_id'=>auth()->user()->id,
            ])->first();

    	if($translation) {
    		$translation->value = $request->input('value');
    		$translation->save();
    	} else {
        	$translation = AlternativeText::create(array_merge($request->all(),array(
                'user_id'=>auth()->user()->id,
            )));
    	}
        $this->checkBadge($request, 'alternativ-text', auth()->user()->getNbAlternative());

        return '';
    }
}
