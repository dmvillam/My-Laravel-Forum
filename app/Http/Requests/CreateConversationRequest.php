<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class CreateConversationRequest extends Request {

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
				'pm_folder_id' => '',
				'user_id' => 'required',
				'dest_users' => 'required',
				'subject' => '',
				'content' => 'required',
		];
	}

	public function messages()
	{
		return [
			'pm_folder_id.required' => 'Deja de modificar el html de la página anon juanquer, te estoy viendo jeje es neta.',
		];
	}

}
