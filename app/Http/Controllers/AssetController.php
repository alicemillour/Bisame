<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExportedCorpus;
use Response, View;

use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    /**
     * Send an asset.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
		$response = Response::make(View::make(str_replace('.','-',$request->input('asset')))->render(), '200');

		$response->header('Content-Type', "application/javascript");

		return $response;

    }
	
    /**
     * Send a conll file.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConll(Request $request)
    {
        $exported_corpus_id = $request->input('exported_corpus_id');
        $exported_corpus = ExportedCorpus::where('id', '=', $exported_corpus_id)->firstOrFail();
		$headers=['Content-Type'=> "text/css"];
		$response = Response::download(storage_path('export/'.$exported_corpus->file), $exported_corpus->file, $headers);

		return $response;

    }
}
