
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
***********Base Controller*****************
*******************************************/

Route::get('/contact', 'BaseController@viewContactPage');

/*******************************************
***********User Controller*****************
*******************************************/

Route::get('/login','UserController@getLogin');
Route::post('/login','UserController@postLogin');

Route::get('/register','UserController@getRegister');
Route::post('/register','UserController@postRegister');

Route::get('register/success','UserController@getRegisterSuccess');
Route::get('register/confirm/xy22{user_id}az/{confirmcode}','UserController@getRegisterConfirm');

Route::get('logout','UserController@getLogout');

Route::get('view/profile', 'UserController@viewUserProfile');
Route::get('view/profile/{username}','UserController@viewUserProfileByName');
Route::get('edit/profile', 'UserController@getEditProfile');
Route::post('edit/profile', 'UserController@postEditProfile');
Route::get('edit/password', 'UserController@getChangePassword');
Route::post('edit/password', 'UserController@postChangePassword');

/*******************************************
***********Admin Controller*****************
*******************************************/

Route::get('admin/login','AdminController@getAdminLogin');
Route::post('admin/login','AdminController@postAdminLogin');
Route::get('admin/home','AdminController@getAdminHome');

Route::post('admin/changeUserPriveleges','AdminController@postchangeUserPriveleges');
Route::post('json/admin/toggleBlock','AdminController@postBlockUser');

//Manage branches
Route::get('admin/branches', 'AdminController@manageBranches');
Route::post('admin/add/branches', 'AdminController@addNewBranch');
Route::get('admin/branches/edit', 'AdminController@getEditBranch');
Route::post('admin/branches/edit', 'AdminController@postEditBranch');

//Manage subjects
Route::get('admin/subjects', 'AdminController@manageSubjects');
Route::post('admin/add/subjects', 'AdminController@addNewSubject');
Route::get('admin/subjects/edit', 'AdminController@getEditSubject');
Route::post('admin/subjects/edit', 'AdminController@postEditSubject');

//Manage modules
Route::get('admin/modules', 'AdminController@manageModules');
Route::post('admin/add/modules', 'AdminController@addNewModule');
Route::get('admin/modules/edit', 'AdminController@getEditModule');
Route::post('admin/modules/edit', 'AdminController@postEditModule');


/*******************************************
***********Question Controller**************
*******************************************/

Route::get('/','QuestionController@viewAllQuestions');

//Adding
Route::get('add/question','QuestionController@getAddQuestion');
Route::post('add/question','QuestionController@postAddQuestion');

Route::post('add/answer','QuestionController@postAddAnswer');
Route::post('add/addVote','QuestionController@postAddVote');

//Edit
Route::get('edit/question','QuestionController@getEditQuestion');
Route::post('edit/question','QuestionController@postEditQuestion');

Route::get('edit/answer','QuestionController@getEditAnswer');
Route::post('edit/answer','QuestionController@postEditAnswer');

//View
Route::get('view/question','QuestionController@getViewQuestion'); //1
Route::get('view/questions', 'QuestionController@viewAllQuestions');//All

//View posts for user
Route::get('user/{id}/questions','QuestionController@getQuestionsForUser');
Route::get('user/{id}/answers','QuestionController@getAnswersForUser');

//Searching
Route::get('search/questions/tag/{tag}', 'QuestionController@viewQuestionsByTags');
Route::get('search/questions', 'QuestionController@viewQuestionList');
Route::get('search/questions/sort/{sort}/filter/{type}', 'QuestionController@sortQuestionList');

//Add a flag
Route::post('json/add/flag','QuestionController@postJSONAddFlag');

//Get Related Questions via JSON
Route::get('json/relatedquestions','QuestionController@getJSONRelatedQuestions');
Route::post('json/relatedquestionstags','QuestionController@postJSONRelatedQuestionsTag');

//University Questions
Route::get('add/univquestion', 'QuestionController@getAddUnivQuestion');
Route::post('add/univquestion', 'QuestionController@postAddUnivQuestion');
Route::post('edit/univquestion', 'QuestionController@postEditUnivQuestion');
Route::get('univquestions/mainpage', 'QuestionController@univQuestionsMainPage');
Route::get('univquestions/view', 'QuestionController@viewUnivQuestions');
Route::get('univquestions/view/paper/{exam}', 'QuestionController@viewUnivQuestionsByDate');
Route::get('univquestions/view/branch','QuestionController@getSubUnderBranch');

/*******************************************
***********Moderator Controller*************
*******************************************/

Route::get('moderator/home','ModeratorController@getModeratorHome');

//Flags
Route::get('moderator/flags','ModeratorController@getViewFlags');
Route::get('json/moderator/nextflag','ModeratorController@getJSONNextFlag');
Route::post('json/moderator/nextflag','ModeratorController@postJSONNextFlag');

//Review edits
Route::get('moderator/review','ModeratorController@getModeratorReviews');
Route::get('json/moderator/newreview','ModeratorController@getJSONNextModeratorReview');
Route::post('json/moderator/newreview','ModeratorController@postJSONNextModeratorReview');


//Controller to handle all our CRON jobs, mail etc.
/*******************************************
***********Worker Controller*************
*******************************************/


Route::get('mail',function(){
		//return View::make('mail',array('user'=>'cjds'));
	   Mail::send('emails.confirm', array('user'=>'Carl','link'=>'nothing'), function($message){
       $message->to('cjds@live.com', 'Carl Saldanha')->subject('Welcome to GradHat');
    	});
});
?>