<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditLogoRequest extends Request {

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
			'logo' => 'required|mimes:jpeg,jpg,png,gif',
		];
	}

	public function messages()
	{
		return [
			'logo.required' => 'Aún no ha subido un logo.',
			'logo.mimes' => 'Sólo se admiten los tipos de archivo: jpeg, jpg, png, gif.',
		];
	}

}
