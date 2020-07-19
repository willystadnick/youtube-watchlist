<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Search extends FormRequest
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
            'search' => 'required|string',
            'day1' => 'required|integer',
            'day2' => 'required|integer',
            'day3' => 'required|integer',
            'day4' => 'required|integer',
            'day5' => 'required|integer',
            'day6' => 'required|integer',
            'day7' => 'required|integer',
        ];
    }
}
