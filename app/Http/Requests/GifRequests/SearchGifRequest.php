<?php

namespace App\Http\Requests\GifRequests;

use Illuminate\Foundation\Http\FormRequest;

class SearchGifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'query' => 'required|string',
            'limit' => 'integer|min:1|max:15',
            'offset' => 'integer|min:0|max:15',
        ];
    }
}
