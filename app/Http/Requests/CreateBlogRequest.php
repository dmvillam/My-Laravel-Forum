<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBlogRequest extends Request {

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
            'name' => 'required',
            'desc' => '',
			'user_id' => 'required',
            'banner' => 'mimes:jpeg,jpg,png,gif',
		];
	}

    public function messages()
    {
        return [
            'banner.mimes' => 'Error del banner: sólo se admiten los tipos de archivo: jpeg, jpg, png, gif.',
        ];
    }
}
