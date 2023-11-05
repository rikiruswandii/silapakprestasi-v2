<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Session\Session;
use Config\Services;
use Config\View;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    /**
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * @var array
     */
    protected $helpers = [
        'form',
        'cookie',
        'filesystem',
        'html',
        'settings',
        'users',
        'utils',
        'icons',
        'apps'
    ];

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var BaseConnection
     */
    protected $db;

    /**
     * @var object|array
     */
    protected $settings;

    /**
     * @var mixed
     */
    protected $userdata;

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = session();
        $this->db = db_connect();
        $this->settings = settings();
        $this->userdata = userdata();

        $apikey = $this->session->get('apikey');
        if (!$apikey) {
            $this->session->set('apikey', hashids(mt_rand()));
        }
    }

    /**
     * @param string $name
     * @param array  $data
     * @param array  $options Unused - reserved for third-party extensions.
     *
     * @return string
     */
    protected function view(string $name, array $data = [], array $options = [])
    {
        $renderer = Services::renderer();

        $saveData = config(View::class)->saveData;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        return $renderer
            ->setVar('settings', $this->settings)
            ->setVar('userdata', $this->userdata)
            ->setData($data, 'raw')
            ->render($name, $options, $saveData);
    }
}
