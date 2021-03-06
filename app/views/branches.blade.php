@extends('layouts.master')

@section('content')

<div class="row">
	<div class="columns">

		<h3>Add New Branch</h3>
		
		{{Form::open(array('url'=>'admin/add/branches'))}}
		{{Form::label('branch_name', 'Branch Name')}} 
		{{Form::text('branch_name', '', array('style' => 'width:400px'))}} <br>
		{{Form::label('branch_shortname', 'Branch Shortname')}} 
		{{Form::text('branch_shortname', '', array('style' => 'width:400px'))}} <br>
		{{Form::submit('Add Branch', array('class' => 'button'))}}
		{{Form::close()}}
		<br>

		<h3>All Branches</h3>
		<div class="row">
			<table class="columns large-5">
	  			<thead>
					<tr>
						<th>Branch Name</th>
						<th>Short Name</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead> 
				<tbody>
					@foreach($branches as $branch)
						<tr style='align:left'>
							<td>{{$branch->branch_name}} </td>
							<td>{{$branch->branch_shortname}} </td>
							<td><a href="{{url('admin/branches/edit')}}?bid={{$branch->branch_id}}">edit</a></td>
							<td><a href="#">delete</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop