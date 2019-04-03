<?php


namespace App\Services;


use GuzzleHttp\Exception\GuzzleException as GuzzleExceptionAlias;
use Psr\Http\Message\ResponseInterface;

class RedmineService extends IntegrationService
{
    protected $actionsList = [
        'getAllProjects',
        'getIssuesForProject',
        'trackTime'
    ];


    /**
     * @return mixed
     * @throws GuzzleExceptionAlias
     */
    protected function getAllProjectsAction()
    {
        $response = $this->client->request('GET', "{$this->url}/projects.json", [
            'query' => [
                'key' => $this->key
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response['projects'];
    }

    /**
     * @param int $id
     * @return mixed|ResponseInterface
     * @throws GuzzleExceptionAlias
     */
    protected function getIssuesForProjectAction(int $id)
    {
        $response = $this->client->request('GET', "{$this->url}/issues.json", [
            'query' => [
                'key' => $this->key,
                'project_id' => $id
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response['issues'];
    }

    /**
     * @param string $what
     * @param int $id
     * @param int $hours
     * @return mixed|ResponseInterface
     * @throws GuzzleExceptionAlias
     */
    protected function trackTimeAction(string $what, int $id, int $hours)
    {
        $response = $this->client->request('POST', "{$this->url}/time_entries.json", [
            'form_params' => [
                "{$what}_id" => $id,
                'hours' => $hours,
            ],
            'headers' => [
                'X-Redmine-API-Key' => $this->key
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}