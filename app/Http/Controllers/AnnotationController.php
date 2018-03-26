<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Annotation;
use App\Postag;
use App\Traits\Badgeable;

class AnnotationController extends Controller
{
    use Badgeable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
 		
 		if($request->input('postag_id')==0){
 			$postag_id = null;
            $points = 0;
 		} else {
			$postag_id = $request->input('postag_id');
            $postag = Postag::findOrFail($postag_id);
            $points = $postag->points;
 		}
 		
		$annotation = Annotation::updateOrCreate(
		    ['user_id' => auth()->id(), 'word_id' => $request->input('word_id')],
		    ['postag_id' => $postag_id, 'points' => $points]
		);

		return response()->json($annotation);
    }

}
