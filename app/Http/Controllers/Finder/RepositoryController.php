<?php

namespace App\Http\Controllers\Finder;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Github\Github;
use Khill\Lavacharts\Lavacharts;

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

    public function showRepository($user, $repo)
    {
        $repository = $this->github->get($user, $repo)->dispatch();

        $this->prepareStatsCharts($user, $repo);

        return view('repository.show', [
            'repository' => $repository
        ]);   
    }

    public function issues($user, $repo)
    {
        $repository = $this->github->get($user, $repo)->dispatch();

        $issues = $this->github->issues($user, $repo)->dispatch();

    	return view('issues.list', [
    		'repository' => $repository,
    		'issues' => $issues,
    	]);
    }

    public function showIssue($user, $repo, $no)
    {
        $repository = $this->github->get($user, $repo)->dispatch();

        $issue = $this->github->issues($user, $repo, $no)->dispatch();

        $comments = $this->github->issues($user, $repo, $no)->comments()->dispatch();

        return view('issues.show', [
            'repository' => $repository,
            'issue' => $issue,
            'comments' => $comments,
        ]);
    }   

    private function prepareStatsCharts($user, $repo)
    {
        $dt = new \Carbon\Carbon('last month');

        $since = $dt->toIso8601String();

        $commits = $this->github->get($user, $repo)->commits()->dispatch(10, $since);

        $commitsDataTable  = \Lava::DataTable();

        $commitsDataTable->addStringColumn('Users')
            ->addNumberColumn('Commits')
            ->addNumberColumn('Additions (++)')
            ->addNumberColumn('Deletions (--)');

        foreach ($commits as $commit) 
        {
            $completeCommitdata = $this->github->get($user, $repo)->commits($commit->sha)->dispatch();

            $commitsDataTable->addRow([
                $commit->author->login , 
                $completeCommitdata->stats->total,
                $completeCommitdata->stats->additions,
                $completeCommitdata->stats->deletions,
            ]);
        }

        \Lava::BarChart('CommitsChart')->setOptions(array(
            'datatable' => $commitsDataTable,
            'height' => 450,
            'title' => 'Commits of Top Ten Contributors since: ' . $dt->format('M d, Y')
        ));
    }

}
