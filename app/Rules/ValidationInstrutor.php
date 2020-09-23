<?php

namespace App\Rules;

use User;
use Illuminate\Contracts\Validation\Rule;

class ValidationInstrutor implements Rule
{

  public function passes($attribute, $value)
  {
    $user = User::where('id',$value)->get();
    return $user->tipo_socio === 'P';


  }

  public function message()
  {
      return 'O id do piloto não é instrutor.';
  }

}
