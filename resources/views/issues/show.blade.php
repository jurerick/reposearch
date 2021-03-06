@extends('layouts.master')

@section('module', 'issues')


@section('content')
<div class="row columns">

	<nav aria-label="You are here:" role="navigation">
	  <ul class="breadcrumbs">
	    <li><a href="{{ route('web.finder') }}"><i class="fi-home"></i> Home</a></li>
	    <li><a href="{{ route('web.repository', ['user'=> $repository->owner->login, 'repo'=> $repository->name]) }}">{{ $repository->name }}</li>
	    <li><a href="{{ route('web.issues', ['user'=> $repository->owner->login, 'repo'=> $repository->name]) }}">Issues</a></li>
	    <li><span class="show-for-sr">Current: </span> Discussion</li>
	  </ul>
	</nav>

	<div class="issue-basic-info">
		<h5>
			<a href="{{ route('web.repository', ['user'=>$repository->owner->login, 'repo'=>$repository->name]) }}">
				{{ $repository->owner->login }}
			</a> / 
			<strong>{{ $repository->name }}</strong>			
		</h5>
		<h1>{{ $issue->title }} <span class="subheader">#{{ $issue->number }}</span></h1>
		<ul>
			<li>Created At: <strong>{{ Carbon\Carbon::parse($issue->created_at)->format('M d, Y g:iA')  }}</strong></li>
			<li>By: <strong>{{ $issue->user->login }}</strong></li>
		</ul>
	</div>
	<!--.issue-basic-info ends-->
	<hr />

	<div class="comments-block row columns">

		<div class="media-object">
		  <div class="media-object-section">
		    <div class="thumbnail">
		      <img src="{{ $issue->user->avatar_url }}">
		    </div>
		  </div>
		  <div class="media-object-section">
		  	<strong>{{ $issue->user->login }}</strong> 
		  	<span class="grey"><small>Posted: {{ Carbon\Carbon::parse($issue->created_at)->format('M d, Y g:iA') }}</small></span>
		    <p>{{ $issue->body }}</p>

		    	<!-- Nested Comments Starts here -->
		    	@if($comments)

					@foreach($comments as $comment)

						<div class="media-object">
					      <div class="media-object-section">
					        <div class="thumbnail">
					          <img src="{{ $comment->user->avatar_url }}">
					        </div>
					      </div>
					      <div class="media-object-section">
					        <strong>{{ $comment->user->login }}</strong> 
					        <span class="grey"><small>Posted: {{ Carbon\Carbon::parse($comment->created_at)->format('M d, Y g:iA') }}</small></span>
					        <p>{{ $comment->body }}</p>
					      </div>
					    </div>

					@endforeach

				@else

					<p class="text-center">No comments at the moment.</p>
				@endif

		  </div>
		</div>

	</div>

</div>
<div class="row columns">
	<div id="show-issue-block">
		
	</div>
</div>
@endsection