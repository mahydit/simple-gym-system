<?php

namespace App\Http\Requests\Gym;

use Illuminate\Foundation\Http\FormRequest;

class StoreGymRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
<<<<<<< HEAD
            'image' => 'required|image|mimes:jpeg,jpg',
=======
>>>>>>> 1a25e896e459e195cc52b992a4a6554e1f218909
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
