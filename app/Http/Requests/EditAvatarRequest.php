<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditAvatarRequest extends Request {

    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

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
			'avatar' => 'required|mimes:jpeg,jpg,png,gif',
		];
	}

	public function messages()
	{
		return [
			'avatar.required' => 'Aún no ha subido un avatar.',
			'avatar.mimes' => 'Sólo se admiten los tipos de archivo: jpeg, jpg, png, gif.',
		];
	}
}
