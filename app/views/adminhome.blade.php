@extends('layouts.master')


@section('content')

<script type="text/javascript">
	$(document).ready(function(){
		var user_id=-1;
		$('a.blockbtn').click(function(e){
			e.preventDefault();
			user_id= $(this).attr('data-id');
			$.ajax({
  				type: "POST",
  				url: "{{url('json/admin/toggleBlock')}}",
  				dataType:'json',
  				data: { user_id: $(this).attr('data-id') }
  			}).done(function(json){
  				if(json.type=='block'){
  					$('a.blockbtn[data-id='+user_id+']').html('Unlock');
  				}
  				else{
  					$('a.blockbtn[data-id='+user_id+']').html('Block');
  				}
  			});
		});

	});
  
</script>


<div class="row">
<div class="columns">

			<h3>Change Priveleges</h3>
			{{Form::open(array('url'=>'admin/changeUserPriveleges'))}}	
			<table class='table'>
			<thead>
				<tr>
					<th>Username</th>
					<th>Privelege Level</th>
					<th>Block Users</th>
				</tr>
			</thead>
				<tbody>
				@foreach ($users as $user) 
				</tr>
				<td>
					{{$user->user_username}}
				</td>
				<td>		
					<select name="privilegelevel[{{$user->user_id}}]"> 					
						<option value=0 {{($user->privelege_level==0)?'selected':''}}>User</option>
						<option value=15 {{($user->privelege_level==15)?'selected':''}}>Moderator</option>
						<option value=21 {{($user->privelege_level==21)?'selected':''}}>Administrator</option>
					</select>
				</td>
				<td>
					@if($user->user_blocked)
						<a class='blockbtn' data-id='{{$user->user_id}}' href='#'>Unblock</a>
					@else
						<a class='blockbtn' data-id='{{$user->user_id}}' href='#'>Block</a>
					@endif
				</td>
				</tr>
				@endforeach
				</tbody>
				</table>
				{{Form::submit('Change Priveleges',array('class'=>'button'));}}

			{{Form::close();}}
</div>
</div>
<div class='row'>
<div class='columns'>
<ul>
<li>{{HTML::link('admin/branches', "Branches" );}}</li>
<li>{{HTML::link('admin/subjects', "Subjects" );}}</li>
<li>{{HTML::link('admin/modules', "Modules");}}</li>
</div>
</ul>
</div>

@stop