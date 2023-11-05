<?php

use App\Models\SectorsModel;

function sectors($parent = null, $child = true)
{
    $sectors = new SectorsModel();

    if (is_null($parent)) {
        $top = $sectors->select('id, name, slug')
            ->where('parent IS NULL', null, false)
            ->orderBy('name', 'ASC')
            ->findAll();

        $result = [];
        array_map(function ($row) use (&$result, $child) {
            $id = $row->id;
            unset($row->id);

            $item = $row;
            if ($child === true) {
                $item->children = sectors($id);
            }

            $result[] = $item;
        }, $top);

        return $result;
    }

    $children = $sectors->select('name, slug')
        ->where('parent', $parent)
        ->findAll();

    $result = [];
    array_map(function ($row) use (&$result) {
        $result[] = $row;
    }, $children);

    return $result;
}

function regulations($slug = null)
{
    $categories = [
        'investment' => 'Bidang Penanaman Modal',
        'service' => 'Bidang Pelayanan Publik'
    ];

    return is_null($slug)
        ? array2object($categories)
        : ($categories[$slug] ?? null);
}

function subregulations($slug = null)
{
    $categories = [
        'law' => 'Undang-Undang',
        'presidential' => 'Peraturan Presiden',
        'government' => 'Peraturan Pemerintah',
        'ministerial' => 'Peraturan Menteri',
        'regional' => 'Peraturan Daerah',
        'regent' => 'Peraturan Bupati',
        'regent-decre' => 'Keputusan Bupati',
        'hos' => 'Keputusan Kepala Dinas'
    ];

    return is_null($slug)
        ? array2object($categories)
        : ($categories[$slug] ?? null);
}

function districts($validation = false)
{
    $districts = [
        3214010 => 'Jatiluhur',
        3214011 => 'Sukasari',
        3214020 => 'Maniis',
        3214030 => 'Tegalwaru',
        3214040 => 'Plered',
        3214050 => 'Sukatani',
        3214060 => 'Darangdan',
        3214070 => 'Bojong',
        3214080 => 'Wanayasa',
        3214081 => 'Kiarapedes',
        3214090 => 'Pasawahan',
        3214091 => 'Pondok Salam',
        3214100 => 'Purwakarta',
        3214101 => 'Babakancikao',
        3214110 => 'Campaka',
        3214111 => 'Cibatu',
        3214112 => 'Bungursari'
    ];

    $type = gettype($validation);

    return !!$validation && $type === 'boolean'
        ? implode(',', array_keys($districts))
        : (!!$validation && $type === 'string'
            ? ($districts[$validation] ?? 'Unknown')
            : $districts);
}
