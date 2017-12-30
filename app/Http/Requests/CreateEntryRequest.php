<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateEntryRequest extends Request {

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
            'title' => 'required',
            'content' => 'required',
			'user_id' => 'required',
			'blog_id' => 'required',
            'pic' => 'mimes:jpeg,jpg,png,gif',
		];
	}

    public function messages()
    {
        return [
            'pic.mimes' => 'Error de la imagen: sólo se admiten los tipos de archivo: jpeg, jpg, png, gif.',
        ];
    }
}
