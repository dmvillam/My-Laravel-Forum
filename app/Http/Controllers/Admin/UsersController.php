<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\CreateUserRequest;

use App\User;
use App\UserProfile;
use Illuminate\Support\Facades\Session;

/**
 * @property  user
 */
class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
	public function index(\Illuminate\Http\Request $request)
	{
        $users = User::filterAndPaginate($request->get('name'), $request->get('type'), $request->get('orderby'));

		return view('admin.users.index', [
            'users' => $users,
        ]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateUserRequest $request
	 * @return Response
	 */
	public function store(CreateUserRequest $request)
	{
        $request['fullname'] = $request['firstname'] . ' ' . $request['lastname'];

		$user = User::create($request->all());
        $user->profile()->create(['website' => '', 'twitter' => '', 'bio' => '', 'country_id' => 0]);
		$user->folders()->create(['folder_name' => 'Inbox', 'folder_desc' => 'Bandeja de Entrada']);

		return \Redirect::route('admin.users.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
	public function edit($id)
	{
        $user = User::find($id);

		return view('admin.users.edit', [
            'user' => $user
        ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param EditUserRequest $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(EditUserRequest $request, $id)
	{
        $user = User::find($id);
        $request['fullname'] = $request['firstname'] . ' ' . $request['lastname'];

        $user->fill($request->all());
        $user->save();

        Session::flash('message', 'El usuario <strong>' . $user->nickname . '</strong> ha sido editado!');
        return \Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param \Illuminate\Http\Request $request
	 * @return Response
	 */
	public function destroy($id, \Illuminate\Http\Request $request)
	{
        $user = User::find($id);
        User::destroy($id); // Alternativamente $this->user->delete();

        if ($request->ajax())
        {
            return response()->json([
                'id' => $user->id,
                'message' => 'El usuario ' . $user->nickname . ' fue exitosamente borrado!'
            ]);
        }

        Session::flash('message', 'El usuario <strong>' . $user->nickname . '</strong> fue exitosamente borrado!');
        return redirect()->route('admin.users.index');
	}

}
