<?php

namespace App\Http\Requests\GifRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveGifToFavoritesRequest extends FormRequest
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
            'gif_id' => [
                'required',
                'string',
                Rule::unique('gifs')->where(function ($query) {
                    $query->where('user_id', $this->user_id);
                }),
            ],
            'alias' => 'required|string',
            'user_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'gif_id.unique' => 'The GIF ID has already been registered for this user.',
        ];
    }
}
