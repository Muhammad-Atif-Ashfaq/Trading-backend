<?php

namespace App\Http\Requests\Api\Admin\Brands;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    use ResponseTrait; // TODO: Using the ResponseTrait for sending responses

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255']
        ];
    }
}
