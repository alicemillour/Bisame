<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Report;
use App\Notification;
use App\Recipe;
use Response, Mail;

class ReportController extends Controller
{

    /**
     * Send a new report.
     *
     * @param  App\Http\Requests\ReportRequest $ReportRequest
     * @param  App\Repositories\RelationRepository $relations
     * @return Illuminate\Http\Response
     */
    public function postSend(Request $request)
    {

        if(Auth::check()){
            $data['user_id'] = Auth::user()->id;
            $data['message'] = "Utilisateur : ".Auth::user()->username.'\r\n';              
        } else {
            $data['message'] = "Utilisateur : Non connecté". '\r\n'; 
        }

        if($request->has('recipe_id')){
            //soft delete of the recipe
            $recipe = Recipe::findOrFail($request->input('recipe_id'));
            $url = route('recipes.show', ['recipe' => $recipe]);
            $data['message'] .= 'Adresse de la recette :<br/>';
            $data['message'] .= '<a href="'.$url.'">'.$url.'</a><br/>';
            $recipe->delete();
        }

        $data['message'] .= strip_tags(join('\r\n',$request->input('message')));

        $report = Report::create($data);

        $notification = Notification::where('slug','report')->first();

        foreach($notification->users as $user){
            if($user->email!=''){
                Mail::send('emails.report', ['report' => $report], function ($m) use ($user) {
                    $m->to($user->email, $user->username)->subject('Signalement de contenu inapproprié');
                });
            }
        }

        return redirect()->route('recipes.index')->withSuccess("Merci pour ta participation. Le contenu va être examiné par nos modérateurs.");
    }  

}
