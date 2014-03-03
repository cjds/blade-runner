<?php

class ModeratorController extends BaseController{

	//Moderators and above
	public function getModeratorHome(){
		if (Auth::privelegecheck(15)){
			$title="Moderator Home";
			return View::make('moderatorhome')->with('title',$title);	
		}
		else
			return Redirect::to('login');

	}

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
				$html = new Mark\Michelf\Markdown;
				$flag=$flag[0];
				$allFlags=Flag::where('flag_approved',null)->where('post_id',$flag->post->post_id)->orderBy('created_at','DESC')->get();
				if($flag->post->post_type=="Question"){

					//Markdown and Mathjax server replace
					$flag->post->type->question_body=$html->defaultTransform($flag->post->type->question_body);
   					$flag->post->type->question_body = str_replace('</math>','$$',str_replace('<math>','$$', $flag->post->type->question_body));

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
					//Markdown and Mathjax server replace
					$flag->post->type->answer_body=$html->defaultTransform($flag->post->type->answer_body);
   					$flag->post->type->answer_body = str_replace('</math>','$$',str_replace('<math>','$$', $flag->post->type->answer_body));

					$flag->post->type->question->question_body=$html->defaultTransform($flag->post->type->question->question_body);
   					$flag->post->type->question->question_body = str_replace('</math>','$$',str_replace('<math>','$$', $flag->post->type->question->question_body));
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

	public function getModeratorReviews(){
		//Determine if user is authentic and above Moderator level 15...
		if (Auth::privelegecheck(15)){
			
			return View::make('review')->with('title','Moderator Reviews');
		}
		else{
			return Redirect::to('login');
		}
	}

	public function getJSONNextModeratorReview(){
		if (Auth::privelegecheck(15)){
			$post=SuggestedPost::where('status',0)->orderBy('created_at', 'DESC')->take(1)->get();
			if($post->isEmpty()){
				return Response::json(array('status'=>'fail','type'=>'no_review_left','message'=>'No more reviews left'));
			}
			else{
				$post=$post[0];	
				if($post->post_type=="SuggestedQuestion"){
					
					$tagArray=array();
					foreach ($post->post->type->tags as $tag) 
					 $tagArray[]=$tag->tag_name;

					return Response::json(array('status'=>'success',
												'message'=>'Review Successfully got',
												'type'=>'question',
												'original_title'=> $post->post->type->question_title,
												'new_title'=>$post->type->suggested_edits_question_title,
												'original_body'=>$post->post->type->question_body,
												'new_body'=>$post->type->suggested_edits_question_body,
												'original_tags'=>implode(',', $tagArray),
												'new_tags'=>$post->type->suggested_edits_question_tags,
												'suggested_edits_id'=>$post->suggested_edits_id,
												'edit_explanation'=> $post->editExplanation
												)
										);
				}
				else{
					foreach ($post->post->type->question->tags as $tag) 
						$tagArray[]=$tag->tag_name;
					return Response::json(array('status'=>'success',
												'message'=>'Review Successfully got',
												'type'=>'answer',
												'question_body'=>$post->post->type->question->question_body	,
												'question_title'=>$post->post->type->question->question_title,
												'question_tags'=>implode(',', $tagArray),
												'original_body'=>$post->post->type->answer_body	,
												'new_body'=>$post->type->suggested_edits_answer_body,
												'suggested_edits_id'=>$post->suggested_edits_id,											
												'edit_explanation'=> $post->editExplanation
												)
										);	
				}
			}
			
		}
		else{
			return Response::json(array('status'=>'fail','type'=>'user_authority','message'=>'You do not have sufficient authority'));
		}
	}

	public function postJSONNextModeratorReview(){
		$input=Input::all();
		//Determine if user is authentic and above Moderator level 15...
		if (Auth::privelegecheck(15)){
			if($input['type']=='approve' || $input['type']=='reject'){
				
				$suggested_edits_id=$input['suggested_edits_id'];
				$suggestedEdit=SuggestedPost::findOrFail($suggested_edits_id);
				$suggestedEdit->status=1;
				$suggestedEdit->moderator()->associate(Auth::user());
				if($input['type']=='approve'){
					$suggestedEdit->approvals=$suggestedEdit->approvals+1;
					$post=$suggestedEdit->post;

					//Set all the previous suggested edits that haven't before this to status -1 ..rejected
					SuggestedPost::where('original_post_id',$suggestedEdit->original_post_id)->where('created_at','>',$suggestedEdit->created_at)->update(array('status'=>-1));

					if($suggestedEdit->post_type=='SuggestedQuestion'){
						$post->editor()->associate($suggestedEdit->editor);
						//Normal stuff
						$post->type->question_body=$suggestedEdit->type->suggested_edits_question_body;
						$post->type->question_title=$suggestedEdit->type->suggested_edits_question_title;

						//Attach the new tags
						$question_tags=explode(',',$suggestedEdit->type->suggested_edits_question_tags);
						for ($i=0; $i < count($question_tags); $i++) { 
							$question_tags[$i]=trim($question_tags[$i]);
						}
						$post->type->tags()->detach();

						foreach ($question_tags as $t) {
							$tag_id = Tag::firstOrCreate(array('tag_name' => $t));
							$post->type->tags()->attach($tag_id);
						}

						$post->push();
					}
					else if($suggestedEdit->post_type=='SuggestedAnswer'){
						$post->editor()->associate($suggestedEdit->editor);
						$post->type->answer_body=$suggestedEdit->type->suggested_edits_answer_body;
						$post->push();
					}
					
				}
				else if($input['type']=='reject'){
					$suggestedEdit->rejections=$suggestedEdit->approvals-1;
					$suggestedEdit->status=-1;
				}
				$suggestedEdit->save();
				return Response::json(array('status'=>'success','message'=>'Edit Completed',));
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