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

Route::get('/','UserController@getLogin');

Route::get('/login','UserController@getLogin');
Route::post('/login','UserController@postLogin');
Route::get('/register','UserController@getRegister');

Route::post('/register','UserController@postRegister');
Route::get('logout','UserController@getLogout');

//Route::get('add/question','QuestionController@getAddQuestion');
//Route::post('add/question','QuestionController@postAddQuestion');

Route::get('view/question','QuestionController@getViewQuestion');

Route::post('add/answer','QuestionController@postAddAnswer');
Route::post('add/addVote','QuestionController@postAddVote');

Route::get('edit/question','QuestionController@getEditQuestion');
Route::post('edit/question','QuestionController@postEditQuestion');

Route::get('admin/login','UserController@getAdminLogin');
Route::post('admin/login','UserController@postAdminLogin');
Route::get('admin/home','UserController@getAdminHome');
Route::post('admin/changeUserPriveleges','UserController@postchangeUserPriveleges');
Route::post('json/admin/toggleBlock','UserController@postBlockUser');

Route::get('moderator/home','UserController@getModeratorHome');
Route::get('moderator/review','QuestionController@getModeratorReviews');

/*panktijk*/
Route::get('add/question','TagController@getAddQuestion');
Route::post('add/question','TagController@postAddQuestion');

Route::get('search/questions/tag/{tag}', 'TagController@viewQuestionsByTags');
Route::get('view/questions', 'TagController@viewAllQuestions');
Route::get('search/questions', 'TagController@viewQuestionList');

Route::get('admin/branches', 'AdminController@manageBranches');
Route::post('admin/add/branches', 'AdminController@addNewBranch');

Route::get('admin/subjects', 'AdminController@manageSubjects');
Route::post('admin/add/subjects', 'AdminController@addNewSubject');

Route::get('add/univquestion', 'AdminController@getAddUnivQuestion');
Route::post('add/univquestion', 'AdminController@postAddUnivQuestion');
Route::get('univquestions/mainpage', 'AdminController@univQuestionsMainPage');
Route::get('univquestions/view', 'AdminController@viewUnivQuestions');

Route::get('view/profile', 'AdminController@viewUserProfile');
Route::get('edit/profile', 'AdminController@getEditProfile');
Route::post('edit/profile', 'AdminController@postEditProfile');
Route::get('edit/password', 'AdminController@getChangePassword');
Route::post('edit/password', 'AdminController@postChangePassword');



//******************JSON responses ************************//
Route::get('json/moderator/newreview','QuestionController@getJSONNextModeratorReview');
Route::post('json/moderator/newreview','QuestionController@postJSONNextModeratorReview');

Route::get('search/questions/similar', 'QuestionController@getJSONSimilarQuestions');

//*******************FLAGS**********//
Route::post('json/add/flag','ModeratorController@postJSONAddFlag');
Route::get('moderator/flags','ModeratorController@getViewFlags');
Route::get('json/moderator/nextflag','ModeratorController@getJSONNextFlag');
Route::post('json/moderator/nextflag','ModeratorController@postJSONNextFlag');
?>