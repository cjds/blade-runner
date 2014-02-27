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
		{{Form::submit('Add Branch')}}
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
					</tr>
				</thead> 
				<tbody>
					@foreach($branches as $branch)
						<tr style='align:left'>
							<td>{{$branch->branch_name}} </td>
							<td>{{$branch->branch_shortname}} </td>
							<td><a href='#'>edit</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop