<?php

use CodeIgniter\I18n\Time;
use Hashids\Hashids;

/**
 * Convert array to object
 * @param array $array
 */
function array2object(array $array)
{
    $json = json_encode($array);
    return json_decode($json, false);
}

/**
 * Convert object to array
 * @param object $object
 */
function object2array(object $object)
{
    $json = json_encode($object);
    return json_decode($json, true);
}

/**
 * Get info from IP address
 * @param string $ip
 * @param string $purpose
 * @param boolean $deep_detect
 * @return mixed
 */
function ip_info($ip = null, $purpose = 'location', $deep_detect = true)
{
    $output = null;

    if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
    }

    $purpose = str_replace(
        ['name', '\n', '\t', ' ', '-', '_'],
        '',
        strtolower(trim($purpose))
    );
    $support = ['country', 'countrycode', 'state', 'region', 'city', 'location', 'address'];
    $continents = [
        'AF' => 'Africa',
        'AN' => 'Antarctica',
        'AS' => 'Asia',
        'EU' => 'Europe',
        'OC' => 'Australia (Oceania)',
        'NA' => 'North America',
        'SA' => 'South America'
    ];

    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip));

        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case 'location':
                    $output = [
                        'city' => @$ipdat->geoplugin_city,
                        'state' => @$ipdat->geoplugin_regionName,
                        'country' => @$ipdat->geoplugin_countryName,
                        'country_code' => @$ipdat->geoplugin_countryCode,
                        'continent' => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        'continent_code' => @$ipdat->geoplugin_continentCode
                    ];
                    break;
                case 'address':
                    $address = [$ipdat->geoplugin_countryName];

                    if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                        $address[] = $ipdat->geoplugin_regionName;
                    }
                    if (@strlen($ipdat->geoplugin_city) >= 1) {
                        $address[] = $ipdat->geoplugin_city;
                    }

                    $output = implode(', ', array_reverse($address));
                    break;
                case 'city':
                    $output = @$ipdat->geoplugin_city;
                    break;
                case 'state':
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case 'region':
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case 'country':
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case 'countrycode':
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }

    return $output;
}

/**
 * Convert formatted date into Indonesian date format
 * @param string $date
 * @param boolean $time
 * @return string
 */
function indonesian_date($date, $time = false, $short = false)
{
    $timestamp = strtotime($date);
    $date = Time::createFromTimestamp($timestamp, null, 'id_ID');
    $date = $date->setTimezone('Asia/Jakarta');

    if ($short === true) {
        return $date
            ->toLocalizedString('dd MMM Y');
    }

    if ($time === true) {
        return $date
            ->toLocalizedString('EEEE, dd MMMM Y HH:mm:ss');
    }

    return $date
        ->toLocalizedString('EEEE, dd MMMM Y');
}

/**
 * Generate short unique ids from integers
 * @param int $id
 * @param string $type
 * @return string
 */
function hashids($id, $type = 'encode')
{
    $hashids = new Hashids();

    if ($type === 'encode') {
        return $hashids->encode($id, 22062004);
    } else {
        return $hashids->decode($id)[0] ?? 0;
    }
}

/**
 * Convert text to slug format
 * @param string $section table[field]
 * @param string $text
 * @param string $divider
 * @return string
 */
function slugify($section, $text = '', $divider = '-')
{
    $db = db_connect();

    preg_match_all("/^([a-zA-Z0-9]+)\[([a-zA-Z0-9]+)\]$/", $section, $matches);
    [$matches, $table, $field] = $matches;
    $table = array_shift($table);
    $field = array_shift($field);

    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text) ?? '';
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text) ?? '';
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text) ?? '';
    // trim
    $text = trim($text, $divider) ?? '';
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text) ?? '';

    $slug = empty($text) ? hashids(mt_rand()) : $text;
    $check = $db->table($table)->where($field, $slug)->select(['id', $field])->get()->getLastRow();
    if ($check !== null) {
        $slug = implode('-', [$slug, hashids($check->id)]);
    }

    // lowercase
    $slug = strtolower($slug) ?? '';
    return $slug;
}

/**
 * Cut long text neatly
 * @param string $text
 * @param int $max
 * @return string
 */
function cuttext($text, $max = 72)
{
    if (strlen($text) > $max) {
        $offset = ($max - 3) - strlen($text);
        $text = substr($text, 0, strrpos($text, ' ', $offset)) . ' ...';
    }

    return $text;
}

/**
 * Returns the Datatable full URL
 * @param string $url
 * @param string $append
 * @param object $settings
 * @return string
 */
function append_url($url = null, $append = '', $settings = null)
{
    if ($url === null) {
        $segments = current_url(true)->getSegments();
        $segments = array_filter($segments);
    } else {
        $segments = explode('/', $url);
        $segments = [
            $settings->app_prefix,
            ...$segments
        ];
        $segments = array_filter($segments);
    }

    $segments = [
        ...$segments,
        $append ?: 'datatable'
    ];
    $url = implode('/', $segments);
    return base_url($url);
}

/**
 * Get links to media safely
 * @param string $suffix
 * @param string $filename
 * @return string
 */
function safe_media($suffix = 'thumbnails', $filename = '')
{
    $filename = trim($filename);
    if (filter_var($filename, FILTER_VALIDATE_URL)) {
        return $filename;
    }

    $paths = ['uploads', $suffix, $filename];
    $path = implode('/', $paths);

    if ($filename === null ||
        empty($filename) ||
        (isset($filename) && !file_exists($path))
    ) {
        if ($suffix === 'avatars') {
            return base_url('app/img/avatars/franklin.png');
        }

        return base_url('assets/img/no-image.png');
    }

    return base_url($path);
}
