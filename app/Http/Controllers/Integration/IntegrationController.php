<?php

namespace App\Http\Controllers\Integration;

use App\Http\Requests\GetAllProjectsRequest;
use App\Http\Requests\GetIssuesForProjectRequest;
use App\Http\Requests\TrackTimeRequest;
use App\Services\RedmineService;
use App\Ship\Parents\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class IntegrationController extends Controller
{

    protected $integration;

    /**
     * IntegrationController constructor.
     */
    public function __construct()
    {
        $this->integration = new RedmineService(config('integration.redmine.key'), config('integration.redmine.url'));
    }

    /**
     * @param GetAllProjectsRequest $request
     * @return AnonymousResourceCollectionAlias
     */
    public function getAllProjects(GetAllProjectsRequest $request)
    {
        $projects = $this->integration->do('getAllProjects');

        return response()->json($projects);
    }

    /**
     * @param GetIssuesForProjectRequest $request
     * @return JsonResponse
     */
    public function getIssuesForProject(GetIssuesForProjectRequest $request)
    {
        $issues = $this->integration->do('getIssuesForProject', $request->id);

        return response()->json($issues);
    }

    /**
     * @param TrackTimeRequest $request
     * @return JsonResponse
     */
    public function trackTime(TrackTimeRequest $request)
    {
        $trackTime = $this->integration->do('trackTime', $request->what, $request->id, $request->hours);

        return response()->json($trackTime);
    }

}
