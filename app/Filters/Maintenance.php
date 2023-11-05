<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Maintenance implements FilterInterface
{
    public function __construct()
    {
        // load helpers
        helper('settings');
        helper('icons');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $config = settings();

        // if maintenance mode is true
        if ($config->app_maintenance == true) {
            // declare variable to be passed to view
            $variable = [
                'page' => 'Dalam Perbaikan',
                'settings' => $config
            ];

            // then show maintenance view
            echo view('public/maintenance', $variable);
            // exit process
            exit();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
