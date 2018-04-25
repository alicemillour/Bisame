<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Annotation;
use App\Postag;
use App\Traits\Badgeable;
use DB;

class AnnotationController extends Controller {

    use Badgeable;

    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Request $request) {

        if ($request->input('postag_id') == 0) {
            $postag_id = null;
            $points = 0;
            $points_not_seen = 0;
        } else {
            $postag_id = $request->input('postag_id');
            $postag = Postag::findOrFail($postag_id);
            // How many users have produced this annotation ?
            $count = Annotation::where('word_id', $request->input('word_id'))->where('postag_id', $postag_id)->count();

            if ($count <= 1) {
                // The user is the first or the second to produce this annotation
                $points = 1;
                $points_not_seen = 0;
            } elseif ($count == 2) {
                // The user is the third to produce this annotation
                $points = 2;
                $points_not_seen = 1;
            } elseif ($count == 3) {
                // The user is the fourth to produce this annotation
                $points = 3;
                $points_not_seen = 1;
            } else {
                // at least four users has produced this annotation
                $points = 3;
                $points_not_seen = 0;
            }

            Annotation::where('word_id', $request->input('word_id'))
                    ->where('postag_id', $postag_id)
                    ->update(['points' => $points, 'points_not_seen' => DB::raw('points_not_seen+' . $points_not_seen)]);
        }

        $annotation = Annotation::updateOrCreate(
                        ['user_id' => auth()->id(), 'word_id' => $request->input('word_id')], ['postag_id' => $postag_id, 'points' => $points, 'points_not_seen' => 0]
        );
        debug("check badge");
        $this->checkBadge($request, 'annotation', auth()->user()->getNbAnnotations());

        return response()->json(array_merge($annotation->toArray(), array('score' => auth()->user()->getScore()), array('NbAnnotations' => auth()->user()->getNbAnnotations())));
    }

}
