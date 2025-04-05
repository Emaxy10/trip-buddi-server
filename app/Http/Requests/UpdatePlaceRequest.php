<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceRequest extends FormRequest
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
        $placeId = $this->route('place');//Route parameter {place}
        return [
            //
            'name' => 'required|unique:places,name' . $placeId,
            'description' => 'required|min:10',
            'category' => 'required',
            'rating' => 'nullable|integer|min:1|max:5',
            'location' => 'required',
            'address' => 'required',
            'budget' => 'nullable|integer',
        ];
    }
}
