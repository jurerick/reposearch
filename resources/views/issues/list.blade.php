@extends('layouts.master')

@section('module', 'issues')

@section('content')
<div>
	<div class="row columns">
		<a href="{{ route('web.finder') }}"><i class="fi-home"></i> Home</a>
		<h5>
			<a href="{{ $repository->owner->html_url }}" target="_blank">
				{{ $repository->owner->login }}
			</a> / <strong>{{ $repository->name }}</strong>
		</h5>
		<h1>Issues <span class="badge">{{ $repository->open_issues }}</span></h1>
	</div>
	<div class="row columns">

		@include('_partials.alert')

		<div id="issues-block">

			@if($issues)
				
				<table class="hover">
				  <thead>
				    <tr>
				    	<th width="5%"></th>
				      	<th class="text-center"><i class="fi-info"></i> {{ $repository->open_issues }} Open</th>
				      	<th></th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($issues as $issue)
				    <tr>
			    		<td class="avatar-container">
			    			<img class="avatar" src="{{ $issue->user->avatar_url }}" alt="Photo of Uranus.">
			    		</td>
				      	<td>
					      	<a href="{{ route('web.issues.show', ['user' => $repository->owner->login, 'repo'=> $repository->name, 'no'=> $issue->number]) }}"><strong>{{ $issue->title }}</strong></a>
					      	<ul class="inline-list">
					      		<li>Created At: <strong>{{  Carbon\Carbon::parse($issue->created_at)->format('M d, Y g:iA') }}</strong></li>
					      		<li>Author: <strong>{{ $issue->user->login }}</strong></li>
					      		<li>Comments: <strong>{{ $issue->comments }}</strong></li>
					      	</ul>
				      	</td>
				      	<td class="text-right"><div class="number"><strong>#{{ $issue->number }}</strong></div></td>
				    </tr>
				    @endforeach
				  </tbody>
				</table>

			@else
				<p class="text-center">No issues at the moment.</p>
			@endif

		</div>
	</div>
</div>
@endsection