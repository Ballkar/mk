<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class MessageInitRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'exists:customers,id',
            'schema_id' => 'required_without:text|exists:message_schemas,id',
            'text' => 'required_without:schema_id|string|min:3',
            'with_polish_chars' => 'optional|boolean',
            'date' => 'date',
        ];
    }
}