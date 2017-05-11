<h4>
	<i class="fa fa-list-alt fa-2x fa-fw pull-left text-muted"></i>
	{{$article->name}}
</h4>
<p>{!! str_limit(strip_tags($article->description),230) !!}</p>
<p>
	<a class="readmore-link pull-right" href="{{url('show/'.$article->slug)}}">{!!
		Lang::get('helpdesk.read_more') !!}</a>
</p>