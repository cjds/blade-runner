<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	switch ($code)
    {
        case 403:
            return 
            Response::view('templates.sendmessage', array('head'=>'Error 403','body'=>'We seem to be missing some stuff. We\'re still in beta so that could possibly be our fault. Try Contacting Us (below) if the error persists.'));

        case 404:
            return
            Response::view('templates.sendmessage', array('head'=>'Error 404','body'=>'How did you land up here? Its cold and lonely with nowhere to go. Click our logo in the top left to go home sweet home.'));

        case 500:
            return $exception;
            //Log::error($exception);
        	//return 
            //Response::view('templates.sendmessage', array('head'=>'Error 500','body'=>'Well this is the big one. We\'ve made a mess of our code somewhere. We\'re still in beta so we\'ve got bugs to fix. Tell us what happened (below)'));

        default:
            return Response::view('templates.sendmessage', array('head'=>'Error','body'=>'Guess this was something bad. Even we\'re not sure how you could land up here.'));
    }
    //Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|------------------------------------------------------------------------
|    Extend the Auth Class for my custom Auth to support moderators and privelege levels and all
|------------------------------------------------------------------------
*/
use Auth\AuthLib\AuthGuard;
use Auth\AuthLib\NewAuthProvider;
use Illuminate\Hashing\BcryptHasher;

Auth::extend('Auth_Driver', function()
{
    return new AuthGuard(
        new NewAuthProvider(new BcryptHasher(),'User'),
        App::make('session.store')
    );
});

