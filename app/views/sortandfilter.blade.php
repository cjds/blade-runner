

<a href="#" data-dropdown="drop1" class="button tiny dropdown inline inline small-left medium-right">
<i class="fa fa-sort"></i>
	@if($sort=='recent')
		most recent
	@elseif($sort=='oldest')
		oldest first
	@else
		don't sort
	@endif 
</a>
<ul id="drop1" data-dropdown-content class="f-dropdown">
<li>{{HTML::link('search/questions/sort/none/filter/'.$filter.'?search='.$keyword.$tagSearch, "don't sort")}}</li>
  <li>{{HTML::link('search/questions/sort/recent/filter/'.$filter.'?search='.$keyword.$tagSearch, 'most recent')}}</li>
  <li>{{HTML::link('search/questions/sort/oldest/filter/'.$filter.'?search='.$keyword.$tagSearch, 'oldest first')}}</li>
  
</ul>

<a href="#" data-dropdown="drop2" class="button tiny dropdown inline small-left medium-right" style='margin-right:10px'>
<i class="fa fa-filter"></i>
	@if($filter=='answered')
		answered
	@elseif($filter=='unanswered')
		unanswered
	@else
		view all
	@endif
</a><br>
<ul id="drop2" data-dropdown-content class="f-dropdown">
		<li>{{HTML::link('search/questions/sort/'.$sort.'/filter/all?search='.($keyword).$tagSearch, 'view all')}}</li>
		<li>{{HTML::link('search/questions/sort/'.$sort.'/filter/answered?search='.($keyword).$tagSearch, 'answered only')}}</li>
		<li>{{HTML::link('search/questions/sort/'.$sort.'/filter/unanswered?search='.($keyword).$tagSearch, 'unanswered only')}}</li>
</ul>
