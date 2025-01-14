<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class StoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /*  public function rules(): array
      {
          return [
              'subject' => ['required', 'string'],
              'message' => ['required', 'string'],
              'to_user_id' => ['required', 'integer']
          ];
      } */

}
