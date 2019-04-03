<?php


namespace App\Services;


use App\Interfaces\Integrable;
use GuzzleHttp\Client;

class IntegrationService implements Integrable
{

    protected $key;

    protected $url;

    protected $actionsList = [];

    protected $client;

    /**
     * IntegrationService constructor.
     * @param string $key
     * @param string $url
     */
    public function __construct(string $key, string $url)
    {
        $this->key = $key;
        $this->url = $url;
        $this->client = new Client();
    }

    /**
     * @param string $action
     * @param array $args
     * @return mixed|null
     */
    public function do(string $action, ...$args)
    {
        if (!empty($action) && in_array($action, $this->actionsList)) {
            return $this->runAction($action, $args);
        }

        return null;
    }


    /**
     * @param string $action
     * @param array $args
     * @return mixed
     */
    protected function runAction(string $action, ...$args)
    {
        $args = (array_shift($args));
        return isset($args) ? call_user_func([$this, "{$action}Action"], ...$args) : $this->{"{$action}Action"};
    }

}