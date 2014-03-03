
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to .
| and give it the Closure to execute when that URI is requested.
|
*/


/*******************************************
***********User Controller*****************
*******************************************/

Route::get('/login','UserController@getLogin');
Route::post('/login','UserController@postLogin');
Route::get('/register','UserController@getRegister');
Route::post('/register','UserController@postRegister');
Route::get('logout','UserController@getLogout');
Route::get('admin/branches', 'AdminController@manageBranches');
Route::post('admin/add/branches', 'AdminController@addNewBranch');
Route::get('admin/subjects', 'AdminController@manageSubjects');
Route::post('admin/add/subjects', 'AdminController@addNewSubject');
Route::get('admin/modules', 'AdminController@manageModules');
Route::post('admin/add/modules', 'AdminController@addNewModule');

Route::get('view/profile', 'AdminController@viewUserProfile');
Route::get('edit/profile', 'AdminController@getEditProfile');
Route::post('edit/profile', 'AdminController@postEditProfile');
Route::get('edit/password', 'AdminController@getChangePassword');
Route::post('edit/password', 'AdminController@postChangePassword');

Route::get('register/success','UserController@getRegisterSuccess');
Route::get('register/confirm/xy22{user_id}az/{confirmcode}','UserController@getRegisterConfirm');

Route::get('/contact', 'BaseController@viewContactPage');

/*******************************************
***********Admin Controller*****************
*******************************************/
Route::get('admin/login','UserController@getAdminLogin');
Route::post('admin/login','UserController@postAdminLogin');
Route::get('admin/home','UserController@getAdminHome');
Route::post('admin/changeUserPriveleges','UserController@postchangeUserPriveleges');


Route::post('json/admin/toggleBlock','UserController@postBlockUser');


/*******************************************
***********Question Controller**************
*******************************************/
Route::get('/','QuestionController@viewAllQuestions');
//Add
Route::get('add/question','QuestionController@getAddQuestion');
Route::post('add/question','QuestionController@postAddQuestion');

//Edit
Route::get('edit/question','QuestionController@getEditQuestion');
Route::post('edit/question','QuestionController@postEditQuestion');

Route::get('edit/answer','QuestionController@getEditAnswer');
Route::post('edit/answer','QuestionController@postEditAnswer');

//View
Route::get('view/question','QuestionController@getViewQuestion'); //1
Route::get('view/questions', 'QuestionController@viewAllQuestions');//All

//Answering
Route::post('add/answer','QuestionController@postAddAnswer');
Route::post('add/addVote','QuestionController@postAddVote');

//Searching
Route::get('search/questions/tag/{tag}', 'QuestionController@viewQuestionsByTags');
Route::get('search/questions', 'QuestionController@viewQuestionList');
Route::get('search/questions/sort/{sort}/filter/{type}', 'QuestionController@sortQuestionList');

//Add a flag
Route::post('json/add/flag','QuestionController@postJSONAddFlag');

//Get Related Questions via JSON
Route::get('json/relatedquestions','QuestionController@getJSONRelatedQuestions');
Route::post('json/relatedquestionstags','QuestionController@postJSONRelatedQuestionsTag');

/*******************************************
***********Moderator Controller*************
*******************************************/
Route::get('moderator/home','UserController@getModeratorHome');

//University Questions
Route::get('add/univquestion', 'AdminController@getAddUnivQuestion');
Route::post('add/univquestion', 'AdminController@postAddUnivQuestion');
Route::get('univquestions/mainpage', 'AdminController@univQuestionsMainPage');
Route::get('univquestions/view', 'AdminController@viewUnivQuestions');
Route::get('univquestions/view/paper/{exam}', 'AdminController@viewUnivQuestionsByDate');
Route::get('univquestions/view/branch','AdminController@getSubUnderBranch');

//Flags
Route::get('moderator/flags','ModeratorController@getViewFlags');
Route::get('json/moderator/nextflag','ModeratorController@getJSONNextFlag');
Route::post('json/moderator/nextflag','ModeratorController@postJSONNextFlag');

//Review edits
Route::get('moderator/review','QuestionController@getModeratorReviews');
Route::get('json/moderator/newreview','QuestionController@getJSONNextModeratorReview');
Route::post('json/moderator/newreview','QuestionController@postJSONNextModeratorReview');


//Controller to handle all our CRON jobs, mail etc.
/*******************************************
***********Worker Controller*************
*******************************************/


Route::get('mail',function(){
		//return View::make('mail',array('user'=>'cjds'));
	   Mail::send('emails.confirm', array('user'=>'Carl','link'=>'nothing'), function($message){
       $message->to('cjds@live.com', 'Carl Saldanha')->subject('Welcome to Gradhat');
    	});
});
?>