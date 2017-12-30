<?php namespace App\Http\Controllers\PersonalMessages;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePmFolderRequest;
use App\PmFolder;
use Illuminate\Http\Request;

use App\Http\Requests;

class PmFoldersController extends Controller
{
    public function store(CreatePmFolderRequest $request)
    {
        PmFolder::create($request->all());
        return \Redirect::route('users.pm.index');
    }
}
