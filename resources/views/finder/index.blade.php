@extends('layouts.master')

@section('module', 'finder')

@section('content')
<div ng-controller="FinderController">
	<div class="row columns">
		<h6>Search a Github Repository</h6>
	</div>
	<form action="javascript:void(0)">
	  <div class="row columns">
		  <div class="input-group">
		    <span class="input-group-label">Search</span>
		    <input class="input-group-field" type="text" name="q" placeholder="Enter the name of Repository">
		    <a class="input-group-button button" href="javascript:void(0)" ng-click="search($event)">
		    	<i class="fi-magnifying-glass"></i>
		    </a>
		  </div>
	  </div>
	</form>
	<div id="search-results">

		@include('_partials.alert')

		@include('_partials.loader')
		
		<div ng-show="repositories.items.length" class="hide" id="repositories-block">
			<div class="row">
				<div class="columns medium-6">
					<p>We’ve found @{{ repositories.total_count }} repository results</p>
				</div>
				<div class="columns medium-6 text-right">
					<pagination content="paginationContent" id="pagination"></pagination>
				</div>
			</div>

			<div class="row small-up-1 medium-up-2 large-up-3">

		      	<div class="column" ng-repeat="repo in repositories.items">

			        <div class="profile-card">
			          	<!--img here-->
			          	<div class="profile-info">
				            <h4 class="subheader">
				            	<a href="/repository/user/@{{ repo.owner.login }}/repo/@{{ repo.name }}">@{{ repo.full_name }}</a>
				            </h4>
				            <p>@{{ repo.description }}</p>
				            <ul class="inline-list">
				              <li>
				              	<a href="/repository/user/@{{ repo.owner.login }}/repo/@{{ repo.name }}">
				              		<i class="fi-social-github"></i>
				              	</a>
				              </li>
			             	</ul>
			             	<div class="other-info text-center">
				             	<ul class="no-bullet">
				             		<li>Stargazers: <strong>@{{ repo.stargazers_count }}</strong></li>
				             		<li>Forks: <strong>@{{ repo.forks_count }}</strong></li>
				             	</ul>
			             	</div>
			             	<div class="text-center">
				             	 <span class="alert issues label">
					            	<a href="/issues/user/@{{ repo.owner.login }}/repo/@{{ repo.name }}">
					            		Issues: <strong>@{{ repo.open_issues_count }}</strong>
					            	</a>
					            </span>
				            </div>
			          	</div>
			        </div>

		      	</div>
		    </div>
		</div>
	</div>
</div>
@endsection