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
		$url = 'https://'.$this->api.'/repos/' . $user . '/' . $repo . '?client_id=' . $this->clientId . '&client_secret=' . $this->secret;

		return json_decode( Guzzle::get($url)->getBody() );
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
	public function dispatch()
	{
		$this->url .= '?client_id=' . $this->clientId . '&client_secret=' . $this->secret;

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