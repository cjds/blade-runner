<?php
class NotesController extends Controller{

	public function getViewSubjectNotes($subject,$teacher_id){
		$subject=Subject::where('subject_name',$subject)->firstOrFail();
		$teacher=User::findOrFail($teacher_id);
		return View::make('notes.main')->with('subject',$subject)->with('teacher',$teacher)->with('title','notes');
	}


	public function jsongetNotes(){
		$input=Input::all();
		
		$module_id=$input['module_id'];
		$teacher_id=$input['teacher_id'];
		

		$module=Module::findOrFail($module_id);
		$teacher=User::findOrFail($teacher_id);
		//if teacher is a teacher
		if($teacher->privelege_level>16){
			$notes=Notes::where('module_id',$module_id)->where('user_id',$teacher_id)->get()->toArray();
			for($i=0;$i<count($notes);$i++)
				$notes[$i]['description']=$this->convertToMarkdown($notes[$i]['description']);
			
			return Response::json($notes);
			
		}
		else{
			return Response::json(array('status'=>'fail','message'=>"Not a valid teacher"));
		}
	}

	public function postAddNotes(){
		$input=Input::all();
		$module_id=$input['module'];

		$file=$input['file'];		
		if($file!=null)
			$file->move('uploads',$file->getClientOriginalName());
		$n=new Notes();
		$n->module_id=$module_id;
		$n->description=$input['wmd-input'];
		if($file!=null)
			$n->file=$file->getClientOriginalName();
		$n->user_id=Auth::user()->user_id;
		$n->save();


	}

	public function convertToMarkdown($text){
		$html = new Mark\Michelf\MarkdownExtra;
		$text=$html->defaultTransform($text);
   		$text= str_replace('</math>','$',str_replace('<math>','$', $text));
   		return $text;
	}
}
?>