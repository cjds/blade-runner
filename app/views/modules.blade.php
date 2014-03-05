@extends('layouts.master')

@section('content')

<div class="row">
	<div class="large-4 small-12 columns">
		<h3>Add New Module</h3>
		{{Form::open(array('url'=>'admin/add/modules'))}}
		{{Form::label('module_name', 'Module Name')}} 
		{{Form::text('module_name', '', array('style' => 'width:400px'))}} <br>
		{{Form::label('module_subject', 'Subject')}}
		{{Form::select('module_subject', $subjects)}}
		{{Form::submit('Add Module', array('class'=>'button'))}}
		{{Form::close()}}
		<br>
	</div>
</div>
		

		<div class="row">
			<div class="large-8 small-12 columns">
				<h3>All Modules</h3>
					<table class="table">
			  			<thead>
							<tr>
								<th>Module Name</th>
								<th>Subject</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead> 
						<tbody>
							@foreach($modules as $module)
								<tr style='align:left'>
									<td>{{$module->module_name}} </td>
									<td>{{$module->subject->subject_name}}</td>
									<td><a href="{{url('admin/modules/edit')}}?mid={{$module->module_id}}">edit</a></td>
									<td><a href="#">delete</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
			</div>
		</div>
@stop