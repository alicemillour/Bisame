<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;
use Session;

class ContactController extends Controller {

    /**
     * Show the form
     *
     * @return View
     */
    public function showForm() {
        return view('contact');
    }

    /**
     * Email the contact request
     *
     * @param ContactMeRequest $request
     * @return Redirect
     */
    public function sendContactInfo(ContactMeRequest $request) {
        try {
            $data = $request->only('name', 'email');
            $data['messageLines'] = explode("\n", $request->get('message'));
            Mail::send('emails.contact', $data, function ($message) use ($data) {
                $message->subject('Blog Contact Form: ' . $data['name'])
                        ->to(config('mail.contact_email'))
                        ->replyTo($data['email']);
            });
            Session::flash('success', 'Merci, votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return redirect('/');
        } catch (\Swift_TransportException $STe) {
            // logging error
            $string = date("Y-m-d H:i:s") . ' - ' . $STe->getMessage() . PHP_EOL;
            file_put_contents("errorlog.txt", $string  . $request->get('name') . "\n" .  $request->get('email'). "\n" .  $request->get('message') . "\n", FILE_APPEND);
            // send error note to user
            Session::flash('danger', 'Un problème est survenu lors de l\'envoi de votre message, nous allons tenter de résoudre ce problème rapidement. N\'hésitez pas à nous contacter par mail à l\'adresse disponible en bas de page');
            return redirect('/');
        }
    }

//      /**
//     * Get a validator for an incoming registration request.
//     *
//     * @param  array  $data
//     * @return \Illuminate\Contracts\Validation\Validator
//     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => 'required',
//            'email' => 'required|email',
//            'message' => 'required',
//        ]);
//    }
}
