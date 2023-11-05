<?php

use App\Models\UsersModel;

/**
 * Get ID of currently logged user
 * @return int|null
 */
function userid()
{
    return session()
        ->get('userid') ?? null;
}

/**
 * Get details of currently logged user
 * @param string|null $key
 * @param int|null $id
 * @return mixed
 */
function userdata($key = null, $id = null)
{
    $user = new UsersModel();
    $id = $id ?? userid();

    if ($id === null) {
        return null;
    }

    $detail = $user
        ->where('id', $id)
        ->first();

    return isset($key) ? trim($key) : $detail;

}

/**
 * Get a list of permissions
 * @param string|int|null $role
 * @return array|string
 */
function permission($role = null)
{
    $role = $role !== null ? (int)$role : null;
    $roles = [
        1 => 'Administrator',
        'Moderator',
        'User'
    ];

    return $role ? $roles[$role] : $roles;
}

/**
 * Is the current user allowed?
 * @param int|string|array $role
 * @param object $userdata
 * @return boolean
 */
function access_granted($role, $userdata = null)
{
    $roleid = $userdata->role;
    if (is_array($role) && in_array($roleid, $role)) {
        return true;
    }

    return $role == $roleid ? true : false;
}

/**
 * Get avatar link of currently logged user
 * @param string|null $filename
 * @param object $userdata
 * @return string
 */
function avatar($filename = null, $userdata = null)
{
    if ($filename !== null) {
        $filename = trim($filename);
    } else {
        $filename = $userdata->avatar;
    }

    if (filter_var($filename, FILTER_VALIDATE_URL)) {
        return $filename;
    }

    $path = 'uploads/avatars/' . $filename;
    return ($filename && !file_exists($path)) ||
        $filename == null ||
        $filename == '' ?
        base_url('app/img/avatars/franklin.png') :
        base_url('uploads/avatars/' . $filename);
}
