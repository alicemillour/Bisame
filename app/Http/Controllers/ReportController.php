<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Report;
use App\User;
use App\Role;
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

        $data['message'] .= strip_tags(join('\r\n',$request->input('message')));

        $report = Report::create($data);

         $administrators = User::where('is_admin',1)
            ->where('email','!=','')->get();

        foreach($administrators as $recipient){
            Mail::send('emails.report', ['report' => $report], function ($m) use ($recipient) {
                $m->from('contact@zombilingo.org', 'Admin Plural');

                $m->to($recipient->email, $recipient->username)->subject('Signalement de contenu non approprié');
            });
        }

        return back()->withSuccess('Merci pour ta participation');
    }  

}
