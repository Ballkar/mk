<?php

namespace App\Http\Requests\Api\Announcement;

use App\Http\Controllers\Constants\AnnouncementTypes;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            'description' => 'required|min:3|max:200',

            'is_mobile' => 'required_without:is_local|boolean',
            'is_local' => 'required_without:is_mobile|boolean',

            'mobile_price' => 'required_with:is_mobile|numeric',
            'mobile_distance' => 'required_with:is_mobile|numeric',

            'city_id' => 'required|exists:cities,id',
            'road' => 'required_with:is_local|string|min:4',
            'house_number' => 'required_with:is_local|string|min:1',
            'flat_number' => 'string|min:1',
        ];
    }
}
