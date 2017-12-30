<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateThreadRequest extends Request {

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
				'title' => 'required|unique:threads,title',
				'content' => 'required',
				'locked' => 'in:1,0',
				'sticky' => 'in:1,0',
		];
	}

    public function messages()
    {
        return [
            'locked.in' => 'La casilla "Locked" tiene un valor interno no aceptado. Por favor no te la mames anon juanquer.',
            'sticky.in' => 'La casilla "sticky" tiene un valor interno no aceptado. Por favor no te la mames anon juanquer.',
        ];
    }
}
