<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

class ContactMeRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   */
  public function rules()
  {
//        dd($this);
    return [
      'name' => 'required',
      'email' => 'required|email',
      'message' => 'required',
    ];
  }
  public function messages()
    {
        return [
            "name.required" => "Merci de renseigner un nom ou un pseudonyme.",
            "email.required" => "Merci de renseigner une adresse e-mail valide afin que je puisse vous répondre.",
            "message.required" => "Tout commentaire est le bienvenu !",
        ];
    }
  
}
