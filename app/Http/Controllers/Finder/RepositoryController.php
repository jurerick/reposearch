<?php

namespace App\Http\Controllers\Finder;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Github\Github;

class RepositoryController extends Controller
{
    private $github;

    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function index()
    {
    	return view('finder.index');
    }

    public function issues($user, $repo)
    {
        $repository = $this->github->get($user, $repo);

        $issues = $this->github->issues($user, $repo)->dispatch();

    	return view('issues.list', [
    		'repository' => $repository,
    		'issues' => $issues,
    	]);
    }

    public function showIssue($user, $repo, $no)
    {
        $repository = $this->github->get($user, $repo);

        $issue = $this->github->issues($user, $repo, $no)->dispatch();

        $comments = $this->github->issues($user, $repo, $no)->comments()->dispatch();

        return view('issues.show', [
            'repository' => $repository,
            'issue' => $issue,
            'comments' => $comments,
        ]);
    }   


}
