<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $ip_address = $this->request->getIPAddress();
        $ip_address = $ip_address !== '127.0.0.1' &&
            $ip_address !== '0.0.0.0' &&
            $ip_address !== '::1' ?
            $ip_address :
            '180.252.123.41';
        $ip_info = ip_info($ip_address);

        $variable = [
            'parent' => 'Panel',
            'page' => 'Ikhtisar',
            // ...
            'city' => $ip_info['city'],
            'state' => $ip_info['state'],
            'country_code' => strtolower($ip_info['country_code']),
            'country' => $ip_info['country'],
            'ip' => $ip_address,
            'agent' => $this->request->getUserAgent()
        ];

        return $this->view('app/overview', $variable);
    }
}
