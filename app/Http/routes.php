<?php

use \Illuminate\Http\Request;
use \App\Task;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::auth();

    Route::get('/', 'WelcomeController@index');

    Route::get('home', 'HomeController@index');

    Route::get('tset', function(){
        return view('tset.tset');

        $thread = App\Thread::create([]);
        $post = App\Post::create([]);
        $thread->posts()->attach(1); // Thread/Post: Has many
        $post->thread()->attach(1); // Post/Thread: Belongs to


        $conversation = App\PmConversation::create([]);
        $folder = App\PmFolder::create([]);
        $conversation->folders()->attach(1); // Conversation/Folder: Belongs to many
        $folder->conversations()->attach(1); // Folder/Conversation: Belongs to many

        $user = App\User::create([]);
        $profile = App\UserProfile::create([]);
        $user->profile()->attach(1); // User/UserProfile: Has one
        $profile->user()->attach(1); // UserProfile/User: Belongs to
    });
    Route::get('page', function(){return view('tset.page');});

    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);

    Route::get('tasks', ['uses' => 'TaskController@index', 'as' => 'tasks.index']);
    Route::post('tasks/task', ['uses' => 'TaskController@store', 'as' => 'tasks.store']);
    Route::delete('tasks/task/{task}', ['uses' => 'TaskController@destroy', 'as' => 'tasks.destroy']);

    Route::group(['prefix' => 'users'/*, 'middleware' => ['auth', 'is_admin'],*/], function() {
        Route::get('/', ['uses' => 'UsersController@index', 'as' => 'users.index']);
        Route::get('{user}', ['as' => 'users.profile', 'uses' => 'UsersController@show']);
        Route::get('{user}/edit', ['as' => 'users.edit', 'uses' => 'UsersController@edit']);

        Route::put('{user}/update', ['as' => 'users.update', 'uses' => 'UsersController@update']);
        Route::get('{user}/avatar/edit', ['as' => 'users.avatar.edit', 'uses' => 'UsersController@avataredit']);
        Route::put('{user}/avatar/update', ['as' => 'users.avatar.update', 'uses' => 'UsersController@avatarupdate']);
        Route::put('{user}/profile_img/update', ['as' => 'users.profile_img.update', 'uses' => 'UsersController@profileImgUpdate']);

        Route::get('{user}/posts', ['as' => 'user.posts.list', 'uses' => 'UsersController@postsShow']);
        Route::get('{user}/threads', ['as' => 'user.threads.list', 'uses' => 'UsersController@threadsShow']);

        Route::post('{user}/comment/store', ['uses' => 'ProfileCommentsController@store', 'as' => 'profile.comment.store']);
        Route::put('{user}/comment/{comment}/update', ['uses' => 'ProfileCommentsController@update', 'as' => 'profile.comment.update']);
        Route::delete('{user}/comment/{comment}/delete', ['uses' => 'ProfileCommentsController@destroy', 'as' => 'profile.comment.delete']);
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin'], 'namespace' => 'Admin'], function(){
        Route::get('index', [function(){return view('admin.index');}, 'as' => 'admin.index']);
        Route::resource('users', 'UsersController');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', ['uses' => 'CategoriesController@index', 'as' => 'admin.categories.index']);
            Route::post('store', ['uses' => 'CategoriesController@store', 'as' => 'admin.categories.store']);
            Route::get('edit/{category}', ['uses' => 'CategoriesController@edit', 'as' => 'admin.categories.edit']);
            Route::put('update/{category}', ['uses' => 'CategoriesController@update', 'as' => 'admin.categories.update']);
            Route::delete('{category}/delete', ['uses' => 'CategoriesController@delete', 'as' => 'admin.categories.delete']);
        });

        Route::group(['prefix' => 'boards'], function () {
            Route::get('/', ['uses' => 'BoardsController@index', 'as' => 'admin.boards.index']);
            Route::get('create', ['uses' => 'BoardsController@create', 'as' => 'admin.boards.create']);
            Route::post('store', ['uses' => 'BoardsController@store', 'as' => 'admin.boards.store']);

            Route::get('edit/{board}', ['uses' => 'BoardsController@edit', 'as' => 'admin.boards.edit']);
            Route::put('update/{board}', ['uses' => 'BoardsController@update', 'as' => 'admin.boards.update']);
            Route::delete('{board}/delete', ['uses' => 'BoardsController@delete', 'as' => 'admin.boards.delete']);

            Route::put('update/{board}/logo', ['uses' => 'BoardsController@updatelogo', 'as' => 'admin.boards.logo']);
        });

        Route::group(['prefix' => 'galleries'], function () {
            Route::get('/', ['uses' => 'GalleriesController@index', 'as' => 'admin.galleries.index']);
            Route::post('store', ['uses' => 'GalleriesController@store', 'as' => 'admin.galleries.store']);
            Route::put('{gallery}/update', ['uses' => 'GalleriesController@update', 'as' => 'admin.galleries.update']);
            Route::group(['prefix' => '{gallery}/update'], function () {
                Route::put('up', ['uses' => 'GalleriesController@up', 'as' => 'admin.galleries.update.up']);
                Route::put('down', ['uses' => 'GalleriesController@down', 'as' => 'admin.galleries.update.down']);
            });
            Route::delete('{gallery}/delete', ['uses' => 'GalleriesController@destroy', 'as' => 'admin.galleries.delete']);
        });
    });

    Route::group(['prefix' => 'forum', 'namespace' => 'Forum'], function () {
        Route::get('/', ['uses' => 'ForumController@index', 'as' => 'forum.board.index']);
        Route::get('search', ['uses' => 'ForumController@search', 'as' => 'forum.search']);

        Route::get('{board}', ['uses' => 'ThreadController@index', 'as' => 'forum.thread.index']);
        Route::get('{board}/create', ['uses' => 'ThreadController@create', 'as' => 'forum.thread.create']);
        Route::post('{board}/store', ['uses' => 'ThreadController@store', 'as' => 'forum.thread.store']);
        Route::put('{board}/{thread}/update', ['uses' => 'ThreadController@update', 'as' => 'forum.thread.update']);
        Route::delete('{board}/{thread}/delete', ['uses' => 'ThreadController@destroy', 'as' => 'forum.thread.delete']);

        Route::get('{board}/{thread}', ['uses' => 'PostController@index', 'as' => 'forum.post.index']);
        Route::get('{board}/{thread}/create', ['uses' => 'PostController@create', 'as' => 'forum.post.create']);
        Route::post('{board}/{thread}/store', ['uses' => 'PostController@store', 'as' => 'forum.post.store']);
        //Route::get('{board}/{thread}/{post}', ['uses' => 'PostController@show', 'as' => 'forum.post.show']);
        Route::get('{board}/{thread}/{post}/edit', ['uses' => 'PostController@edit', 'as' => 'forum.post.edit']);
        Route::put('{board}/{thread}/{post}/update', ['uses' => 'PostController@update', 'as' => 'forum.post.update']);
        Route::delete('{board}/{thread}/{post}/delete', ['uses' => 'PostController@delete', 'as' => 'forum.post.delete']);
    });

    Route::group(['prefix' => 'pm', 'middleware' => 'auth', 'namespace' => 'PersonalMessages'], function () {
        Route::get('{folder?}', ['uses' => 'PersonalMessagesController@index', 'as' => 'users.pm.index']);
        Route::post('folder/store', ['uses' => 'PmFoldersController@store', 'as' => 'pm.folder.store']);

        Route::get('{folder}/{conversation}', ['uses' => 'PersonalMessagesController@conversation_index', 'as' => 'users.pm.conversation']);
        Route::post('conversation/store', ['uses' => 'PmConversationsController@store', 'as' => 'pm.conversation.store']);
        Route::post('{folder}/{conversation}/reply', ['uses' => 'PmConversationsController@reply', 'as' => 'pm.conversation.reply']);
        Route::delete('{folder}/{conversation}/delete', ['uses' => 'PmConversationsController@destroy', 'as' => 'pm.conversation.delete']);
    });

    Route::group(['prefix' => 'blogs', 'namespace' => 'Blogs'], function () {
        Route::get('/', ['uses' => 'BlogsController@index', 'as' => 'blogs.index']);
        Route::get('create', ['uses' => 'BlogsController@create', 'as' => 'blogs.create']);
        Route::post('store', ['uses' => 'BlogsController@store', 'as' => 'blogs.store']);
        Route::get('{blog}/edit', ['uses' => 'BlogsController@edit', 'as' => 'blogs.edit']);
        Route::put('{blog}/update', ['uses' => 'BlogsController@update', 'as' => 'blogs.update']);
        Route::get('{blog}', ['uses' => 'BlogsController@show', 'as' => 'blogs.show']);
        Route::delete('{blog}', ['uses' => 'BlogsController@destroy', 'as' => 'blogs.destroy']);

        Route::group(['prefix' => '{blog}/entry'], function () {
            Route::get('create', ['uses' => 'EntriesController@create', 'as' => 'blogs.entry.create']);
            Route::post('store', ['uses' => 'EntriesController@store', 'as' => 'blogs.entry.store']);
            Route::get('{entry}', ['uses' => 'EntriesController@show', 'as' => 'blogs.entry.show']);
            Route::get('{entry}/edit', ['uses' => 'EntriesController@edit', 'as' => 'blogs.entry.edit']);
            Route::put('{entry}/update', ['uses' => 'EntriesController@update', 'as' => 'blogs.entry.update']);
            Route::delete('{entry}/destroy', ['uses' => 'EntriesController@destroy', 'as' => 'blogs.entry.destroy']);
        });

        Route::group(['prefix' => 'replies'], function () {
            Route::get('{entry}', ['uses' => 'EntryRepliesController@index', 'as' => 'blogs.reply.index']);
            Route::post('store', ['uses' => 'EntryRepliesController@store', 'as' => 'blogs.reply.store']);
            Route::put('{reply}/update', ['uses' => 'EntryRepliesController@update', 'as' => 'blogs.reply.update']);
            Route::delete('{reply}/destroy', ['uses' => 'EntryRepliesController@destroy', 'as' => 'blogs.reply.destroy']);
        });
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('{tag}', ['uses' => 'TagsController@index', 'as' => 'tags.index']);
    });

    Route::group(['namespace' => 'Gallery'], function() {
        Route::group(['prefix' => 'galleries'], function () {
            Route::get('/', ['uses' => 'GalleriesController@index', 'as' => 'galleries.index']);
            Route::post('store', ['uses' => 'AttachmentsController@store', 'as' => 'galleries.store']);
            Route::get('{gallery}', ['uses' => 'GalleriesController@index', 'as' => 'galleries.show']);
        });

        Route::group(['prefix' => 'attachments/{attachment}'], function() {
            Route::get('/', ['uses' => 'AttachmentsController@index', 'as' => 'gallery.attachments.index']);
            Route::get('show', ['uses' => 'AttachmentsController@show', 'as' => 'gallery.attachments.show']);
            Route::put('update', ['uses' => 'AttachmentsController@update', 'as' => 'gallery.attachments.update']);
            Route::delete('delete', ['uses' => 'AttachmentsController@destroy', 'as' => 'gallery.attachments.destroy']);

            Route::group(['prefix' => 'details'], function() {
                Route::get('edit', ['uses' => 'AttachmentsController@edit', 'as' => 'attachment.details.edit']);
            });
        });

        Route::group(['prefix' => 'galleries/comment'], function () {
            Route::post('store', ['uses' => 'GalleryCommentsController@store', 'as' => 'gallery.comment.store']);
            Route::put('{comment}/update', ['uses' => 'GalleryCommentsController@update', 'as' => 'gallery.comment.update']);
            Route::delete('{comment}/delete', ['uses' => 'GalleryCommentsController@destroy', 'as' => 'gallery.comment.destroy']);
        });
    });

    Route::group(['prefix' => 'search'], function () {
        Route::get('/', ['uses' => 'SearchController@index', 'as' => 'search.index']);
    });

    Route::get('404', function () {return view('errors.404');});
    Route::get('503', function () {return view('errors.503');});
});

