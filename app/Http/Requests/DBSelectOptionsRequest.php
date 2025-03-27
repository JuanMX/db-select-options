<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DBSelectOptionsRequest extends FormRequest
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
            'DBSelectOptions' => 'required|ends_with:' . env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH'),
            'id' => 'nullable|numeric|gt:0'
        ];
    }

    /**

    * Get the error messages for the defined validation rules.

    *

    * @return array<string, string>

    */

    public function messages(): array

    {

        return [
            'DBSelectOptions.required'  => 'A database table name is required',
            'DBSelectOptions.ends_with' => 'The database table name needs to end with: ' . env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH'),
            'id.numeric' => 'A numeric value for the id record is required',
            'id.gt' => 'Invalid record id'
        ];

    }

    /**

    * Get the "after" validation callables for the request.

    */

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!Schema::hasTable($this->DBSelectOptions)) {

                    $validator->errors()->add(
                        'DBSelectOptions',
                        'The table name does not exist in database'
                    );
                }
            }
        ];
    }
}
