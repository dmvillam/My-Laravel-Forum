<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAttachmentRequest extends Request {

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
            'gallery_id' => 'required',
			'user_id' => 'required',
            'pic' => 'mimes:jpeg,jpg,png,gif',
		];
	}

    public function messages()
    {
        return [
            'pic.mimes' => 'Error: sólo se admiten los tipos de archivo: jpeg, jpg, png, gif.',
        ];
    }
}
