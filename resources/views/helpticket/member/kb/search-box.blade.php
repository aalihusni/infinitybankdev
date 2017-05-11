<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-body">
				{!!Form::open(['method'=>'get','action'=>'Member\kb\UserController@search','class'=>'form-inline'])!!}
				<div class="col-md-12">
					<div class="input-group" style="width: 100%;">
						<input type="text" value="{{(isset($search_txt))?''.$search_txt.'':''}}"
							class="search-field form-control input-lg" name="search-text"
							title="Enter search term"
							placeholder="Have a question? Type your search term here..."> <span
							class="input-group-btn ">
							<button type="submit" class="btn btn-warning input-lg">SEARCH!</button>
						</span>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</section>
	</div>
</div>
