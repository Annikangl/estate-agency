<?php

namespace App\Http\Requests\Banners;

use App\Models\Banners\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required|string',
            'limit' => 'required|integer',
            'url' => 'required|url',
        ];
    }
}
