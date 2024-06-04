<?php

use App\Models\SettingsModel;

/**
 * Get all settings for this site
 * @param string $return
 * @return object|array
 */
function settings($return = 'object')
{
    $settings = new SettingsModel();
    $result = $settings->findAll();

    $data = new \stdClass();
    foreach ($result as $row) {
        // insert value into variable
        // check if it's json value
        $value = json_decode($row->content);
        $data->{$row->code} = is_null($value) ? $row->content : $value;
    }

    if ($return === 'array') {
        $json = json_encode($data);
        return json_decode($json, true);
    }
    return $data;
}

/**
 * Create a title with the format
 * Generate HTML title tag
 * @param string $page
 * @param string $name
 * @param string $title
 * @return string
 */
function set_title($page = '', $name = '', $title = '')
{
    $html = '<title>';

    if (empty(trim($page))) {
        $html .= esc($title);
    } else {
        $titles = [
            esc($page),
            esc($name)
        ];

        $html .= implode(' - ', $titles);
    }

    return $html .= '</title>';
}

/**
 * Create a title with the format
 * Generate HTML title tag
 * FOR APP PANEL
 * @param string $page
 * @param string $name
 * @return string
 */
function set_panel_title($page = '', $name = '')
{
    $uri = current_url(true);
    $slug = $uri->getSegments();

    if ($slug[count($slug) - 1] !== 'overview' &&
        $slug[count($slug) - 1] !== 'add' &&
        $slug[count($slug) - 2] !== 'edit'
    ) {
        $page = 'Kelola ' . $page;
    }

    $html = '<title>';

    $titles = [
        esc($page),
        esc($name)
    ];
    $html .= implode(' - ', $titles);

    return $html .= '</title>';
}

/**
 * Get array for sidebar menu
 * @return array
 */
function sidebars()
{
    $uri = current_url(true);
    $slug = $uri->getSegments();

    $slug[0] = '';
    $slug = implode('/', $slug);
    $slug = preg_replace('/\/(add|edit\/([a-zA-Z0-9]+))$/', '', $slug);

    $menus = [
        [
            'name' => 'Ikhtisar',
            'url' => '/overview',
            'icon' => 'home',
            'permission' => ['1'],
            'children' => [],
            'active' => ''
        ],
        [
            'name' => 'Berita',
            'url' => 0,
            'icon' => 'news',
            'permission' => ['1'],
            'children' => [
                [
                    'name' => 'Kategori',
                    'url' => '/categories',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Artikel',
                    'url' => '/news',
                    'permission' => ['1'],
                    'active' => ''
                ],
              	[
                    'name' => 'Slider',
                    'url' => '/sliders',
                    'permission' => ['1'],
                    'active' => ''
                ]
            ],
            'active' => ''
        ],
        [
            'name' => 'Investasi',
            'url' => 0,
            'icon' => 'cash',
            'permission' => ['1'],
            'children' => [
                [
                    'name' => 'Peta Potensi',
                    'url' => '/geojson',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Promosi Investasi',
                    'url' => '/investments',
                    'permission' => ['1'],
                    'active' => ''
                ]
            ],
            'active' => ''
        ],
        [
            'name' => 'Pelayanan',
            'url' => 0,
            'icon' => 'affiliate',
            'permission' => ['1'],
            'children' => [
                [
                    'name' => 'Profil Layanan Instansi',
                    'url' => '/profiles',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Promosi Inovasi',
                    'url' => '/innovations',
                    'permission' => ['1'],
                    'active' => ''
                ]
            ],
            'active' => ''
        ],
        [
            'name' => 'Kelola',
            'url' => 0,
            'icon' => 'adjustments-horizontal',
            'permission' => ['1'],
            'children' => [
                [
                    'name' => 'Regulasi',
                    'url' => '/regulations',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Tentang',
                    'url' => '/about',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Pengguna',
                    'url' => '/users',
                    'permission' => ['1'],
                    'active' => ''
                ]
            ],
            'active' => ''
        ],
        [
            'name' => 'Subscriptions',
            'url' => 0,
            'icon' => 'user-plus',
            'permission' => ['1'],
            'children' => [
                [
                    'name' => 'Daftar Subscriptions',
                    'url' => '/subscriptions',
                    'permission' => ['1'],
                    'active' => ''
                ],
                [
                    'name' => 'Pesan Masuk',
                    'url' => '/contacts',
                    'permission' => ['1'],
                    'active' => ''
                ]
            ],
            'active' => ''
        ]
    ];

    foreach ($menus as $key => $menu) {
        if (count($menu['children']) > 0) {
            $active = 0;

            foreach ($menu['children'] as $index => $children) {
                if ($children['url'] == $slug) {
                    $active += 1;

                    $menus[$key]['children'][$index]['active'] = 'active';
                } else {
                    $menus[$key]['children'][$index]['active'] = '';
                }
            }

            if ($active >= 1) {
                $menus[$key]['active'] = 'active';
            } else {
                $menus[$key]['active'] = '';
            }
        } else {
            if ($menu['url'] == $slug) {
                $menus[$key]['active'] = 'active';
            } else {
                $menus[$key]['active'] = '';
            }
        }
    }

    return array2object($menus);
}
