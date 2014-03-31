@extends('layouts.master')


@section('content')

<script type="text/javascript">
  $(document).ready(function() {

      $('.addbutton').click(function(e){
          $('#adddialog').foundation('reveal','open')
          $('#form_module_id').val($(this).data('moduleid'));
      });

      @foreach($subject->modules as $module)
        $.ajax({
          url: '{{URL::to('json/notes')}}',
          data:{module_id:{{$module->module_id}},teacher_id:{{$teacher->user_id}}},
          dataType:'json'
        })
        .done(function(data) {
          for (var i = 0; i<data.length;i++) {
            var string='<div class="row" style="margin-bottom:20px;"><div class="small-1 columns"><div class="number-circle">'+(i+1)+'</div></div><div style="min-height:36px;" class="small-11 box-sides columns">'+data[i].description;
            if(data[i].file!=null)
              string+='<a href="{{URL::asset('')}}uploads/'+data[i].user_id+'/'+data[i].module_id+'/'+data[i].file+'">'+data[i].file+'</a>';
            string+="</div></div>";


            $('#modulelist li[data-moduleid={{$module->module_id}}] > div').append(string);
          }
        });
      @endforeach

  });
</script>
<div class='row ' data-equalizer-watch >
<div class='medium-3 small-12 column'>
@include("layouts.userprofile",array('user'=>$teacher,'add'=>'')) 

</div>
<div class='medium-9 small-12 column box-sides'>
<h2>{{$subject->subject_name}}</h2>
<br>
<br>
<ul style='list-style:none' id='modulelist'>
@foreach($subject->modules as $module)
<li data-moduleid='{{$module->module_id}}'>
<h3>{{$module->module_name}}</h3>

<div style='padding-bottom:5px'>
  
</div>
@if(Auth::user()==$teacher)
  <input type="button" class="button addbutton tiny" value="Add Lesson" data-moduleid='{{$module->module_id}}'/> 
@endif
</li>
@endforeach
</ul>
</div>
</div>

<div id="adddialog" class="reveal-modal" data-reveal>
    <div class='row'>
        <h2 id="myModalLabel">Add A Lesson</h2>
    </div>
    <div class='row'>
        {{Form::open(array('url'=>'notes/addnotes','id' =>'notes_form','enctype'=>"multipart/form-data"))}}
            
            <input type='hidden' name='module' value='1'  id='form_module_id'/> 
            <input type='file'  name='file'/>
              --------------------OR / AND -----------------
            @include("layouts.markdownmanager",array('data'=>''))
            {{Form::submit('Add Lesson', array('class'=>'button small'));}}
        {{Form::close()}}
    </div>
</div>


@stop