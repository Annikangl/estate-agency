<?php

namespace App\Http\Requests\Banners;

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
        [$width, $height] = [0, 0];
        if ($format = $this->input('format')) {
            [$width, $height] = explode('x', $format);
        }

        return [
            'name' => 'required|string',
            'limit' => 'required|integer',
            'url' => 'required|url',
            'format' => ['required', 'string', Rule::in(Banner::formatsList())],
            'file' => 'required|image|mimes:jpg,jpeg,png|dimensions:width=' . $width . ',height=' . $height,
        ];
    }
}
