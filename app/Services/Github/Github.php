<?php

namespace App\Services\Github;

use Guzzle;

class Github{

	private $clientId;

	private $secret;

	private $api;

	private $url;

	public function __construct()
	{
		$this->api = 'api.github.com';

		$this->clientId = config('services.github.client_id');
		
		$this->secret = config('services.github.secret');
	}

	/**
	* Get the repository
	* @param string $user
	* @param string $repo
	* @return json
	*/
	public function get($user, $repo)
	{
		$this->url = 'https://'.$this->api.'/repos/' . $user . '/' . $repo;

		return $this;
	}

	public function commits($sha = null)
	{
		$this->url .= '/commits';

		if($sha)
		{
			$this->url .= '/' . $sha;
		}

		return $this;
	}

	public function statistics()
	{
		$this->url .= '/stats/contributors';

		return $this;
	}

	/**
	* Get issues of the repository
	* @param string $user
	* @param string $repo
	* @param string $number
	*/
	public function issues($user, $repo, $number = null)
	{
		$this->url = 'https://'.$this->api.'/repos/' . $user . '/' . $repo . '/issues';

		if($number)
		{
			$this->url .= '/' . $number;
		}

		return $this;
	}	

	/**
	* Return the decoded response of the api request.
	* @return json
	*/
	public function dispatch($per_page = 30, $since = null)
	{
		$this->url .= '?client_id=' . $this->clientId . '&client_secret=' . $this->secret . '&per_page=' . $per_page;

		if($since)
		{
			$this->url .= '&since=' . $since;
		}

		return json_decode( Guzzle::get($this->url)->getBody() );
	}

	/**
	* Get comments of single issue
	*/
	public function comments()
	{
		$this->url .= '/comments';

		return $this;
	}

}