<?php

class ModeratorController extends BaseController{


	public function postJSONAddFlag(){
		if(Auth::user()){
			$input=Input::all();
			$flag=new Flag();
			$post=Post::findOrFail($input['post_id']);
			$flag->post()->associate($post);
			if($input['flag-reason']=='Other')
				$flag->flag_reason=$input['flag-reason']."<br>".$input['custom-reason'];
			else
				$flag->flag_reason=$input['flag-reason']."<br>".$input['custom-reason'];
			$flag->creator()->associate(Auth::user());
			$flag->save();
			return Response::json(array('status'=>'success ','message'=>"Thanks! We'll take a look at it"));	
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'user_authority','message'=>'You do not have sufficient authority'));	
		}
	}

	//Moderators and above
	public function getViewFlags(){
		if(Auth::privelegecheck(15)){
			$title="Review Flags";
			return View::make('reviewflag')->with('title',$title);
		}
		else{
			return Redirect::to('login');
		}
	}

	public function getJSONNextFlag(){
		if (Auth::privelegecheck(15)){
			$flag=Flag::where('flag_approved',null)->orderBy('created_at', 'DESC')->take(1)->get();
			if($flag->isEmpty()){
				return Response::json(array('status'=>'fail','type'=>'no_flag_left','message'=>'No more flags'));
			}
			else{
				$flag=$flag[0];
				$allFlags=Flag::where('flag_approved',null)->where('post_id',$flag->post->post_id)->orderBy('created_at','DESC')->get();
				if($flag->post->post_type=="Question"){
					
					return Response::json(array('status'=>'success',
												'message'=>'Flag Successfully got',
												'type'=>'question',
												'title'=> $flag->post->type->question_title,
												'body'=>$flag->post->type->question_body,
												'post_id'=>$flag->post->post_id,
												'flags'=> $allFlags->toArray()
												)
										);
				}
				else{
					return Response::json(array('status'=>'success',
												'message'=>'Flag Successfully got',
												'type'=>'answer',
												'body'=>$flag->post->type->answer_body,
												'question_title'=> $flag->post->type->question->question_title,
												'question_body'=>$flag->post->type->question->question_body,
												'post_id'=>$flag->post->post_id,
												'flags'=> $allFlags->toArray()
												)
										);	
				}
			}
			
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'user_authority','message'=>'You do not have sufficient authority'));
		}
	}

	//
	public function postJSONNextFlag(){
		$input=Input::all();
		if (Auth::privelegecheck(15)){
			if($input['status']=='approve' || $input['status']=='reject'){
				$post_id=$input['post_id'];
				$approved=false;
				if($input['status']=='approve'){
					$approved=true;
				}
				Flag::where('flag_approved',null)->where('post_id',$input['post_id'])->update(array('moderator_id'=>Auth::user()->user_id,'flag_approved'=>$approved ));
				$post=Post::find($input['post_id']);
				if($input['status']=='approve'){
					if($input['type']=='close'){
						$post->update(array('post_open'=>false));
					}
					else if($input['type']=='delete'){
						
						$post->delete();
					}
					else if($input['type']=='block'){
						$post->creator->user_blocked=true;
						$post->creator->save();
					}				
					else if($input['type']=='edit'){
						
					}
				}
				else if($input['status']=='reject'){
					
				}
				return Response::json(array('status'=>'success','message'=>'Flag Updated',));
			}
			else{
				return Response::json(array('status'=>'fail','message'=>'Wrong Input',));
			}
		}
		else{
			return Response::json(array('status'=>'fail','message'=>'Not Enough Authority',));
		}
	}
}


?>