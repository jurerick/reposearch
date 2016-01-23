@extends('layouts.master')

@section('module', 'repository')


@section('content')
<div class="row columns">
	
	<nav aria-label="You are here:" role="navigation">
	  <ul class="breadcrumbs">
	    <li><a href="{{ route('web.finder') }}"><i class="fi-home"></i> Home</a></li>
	    <li><span class="show-for-sr">Current: </span>{{ $repository->name }}</li>
	  </ul>
	</nav>


	<h5>
		<a href="{{ route('web.repository', ['user'=>$repository->owner->login, 'repo'=>$repository->name]) }}">
			{{ $repository->owner->login }}
		</a> / <strong>{{ $repository->name }}</strong>
	</h5>

	<div class="row" id="repo-info-block">
		<div class="columns medium-8 repo-main-info">

			<h4>
				{{ $repository->name }} 
				<small class="subheader">
					<a href="{{ $repository->html_url }}"><i class="fi-social-github"></i> View in Github</a>
				</small>
			</h4>
			<div>{{ $repository->description }}</div>
			<div>
				<small>Language: <strong>{{ $repository->language }}</strong></small>
			</div>
			<p>
			<br />
			<a class="button" href="{{ route('web.issues', ['user'=> $repository->owner->login, 'repo'=>$repository->name]) }}">View Issues</a>
			</p>
		</div>
		<div class="columns medium-4">
			
			<span class="secondary label">Watchers: <strong>{{ $repository->watchers_count }}</strong></span>
			<span class="success label">Stars <strong>{{ $repository->stargazers_count }}</strong></span>
			<span class="warning label">Forks <strong>{{ $repository->forks_count }}</strong></span>

		</div>
	</div>

	<div class="row columns">
		<div id="commits-chart"></div>
	</div>

	@barchart('CommitsChart', 'commits-chart')

</div>
@endsection

