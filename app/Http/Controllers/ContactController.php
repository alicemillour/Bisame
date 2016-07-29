<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
  /**
   * Show the form
   *
   * @return View
   */
  public function showForm()
  {
    return view('contact');
  }

  /**
   * Email the contact request
   *
   * @param ContactMeRequest $request
   * @return Redirect
   */
  public function sendContactInfo(ContactMeRequest $request)
  {
    $data = $request->only('name', 'email', 'phone');
    $data['messageLines'] = explode("\n", $request->get('message'));

    Mail::send('emails.contact', $data, function ($message) use ($data) {
      $message->subject('Blog Contact Form: '.$data['name'])
              ->to(config('mail.contact_email'))
              ->replyTo($data['email']);
    });

    return back()
        ->withSuccess("Thank you for your message. It has been sent.");
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
