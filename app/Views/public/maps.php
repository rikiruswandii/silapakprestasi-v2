<?php
$this->whiteHeader = true;
$this->withoutFooter = true;
?>

<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<link rel="stylesheet" href="<?= base_url('assets/css/L.switchBasemap.css') ?>" />


<style>
    .noselect {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    #maps {
        background-color: #333;
        width: 100%;
        height: calc(100vh - 87px);
        z-index: 0;
    }

    .levious-filter {
        height: 80vh;
        overflow-y: auto;
    }

    #mobile-only {
        height: calc(100vh - 87px);
    }

    .leaflet-draw-toolbar {
        display: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row gx-0" id="desktop-only" style="display: none !important;">
    <!-- Main content -->
    <div class="col-lg-12 align-self-stretch">


        <div id="sideLeft" class="bg-soft-primary sidebarLeft">
            <button id="sidebarToggle" class="btn btn-primary btn-sm tggl-button" style="position:absolute; display:block; left:280px; top:105px;">
                <i id="toggleIcon" class="fas fa-chevron-left"></i>
            </button>
            <!-- Content for sidebarLeft -->
            <div class="menu d-flex">
                <div class="menu-item active" id="layerMenuItem">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4z" />
                        <path d="m2.125 8.567-1.86.992a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882l-1.86-.992-5.17 2.756a1.5 1.5 0 0 1-1.41 0l-5.17-2.756z" />
                    </svg>
                    Layer
                </div>
                <div class="menu-item" id="filterMenuItem">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z" />
                    </svg>
                    Filter
                </div>
            </div>

            <div class="p-2 content" id="filterContent">
                <div class="input-group">
                    <label for="layer-filter" class="input-group-text">Pilih Kecamatan:</label>
                    <select id="layer-filter" class="form-select">
                        <option value="all">Semua</option>
                        <option value="Sukatani">Sukatani</option>
                        <option value="Jatiluhur">Jatiluhur</option>
                        <option value="Bungursari">Bungursari</option>
                        <option value="Cibatu">Cibatu</option>
                        <option value="Darangdan">Darangdan</option>
                        <option value="Sukasari">Sukasari</option>
                        <option value="Tegalwaru">Tegalwaru</option>
                        <option value="Wanayasa">Wanayasa</option>
                        <option value="Maniis">Maniis</option>
                        <option value="Pasawahan">Pasawahan</option>
                        <option value="Plered">Plered</option>
                        <option value="Purwakarta">Purwakarta</option>
                        <option value="Kiarapedes">Kiarapedes</option>
                        <option value="Bojong">Bojong</option>
                        <option value="Pondoksalam">Pondoksalam</option>
                        <option value="Babakancikao">Babakancikao</option>
                        <option value="Campaka">Campaka</option>
                    </select>
                </div>
            </div>

            <div class="content" id="layerContent">
                <div class="pengukuran p-1">
                    <div class="d-flex justify-content-evenly align-items-right" style="margin-left: 20px;">
                        <div class="btn-group" role="group" aria-label="Group 1">
                            <button id="btnMarkers" type="button" class="btn btn-primary btn-sm marker-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </button>

                            <button id="btnPolyline" type="button" class="btn btn-primary btn-sm polyline-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-slash-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                                </svg>
                            </button>

                            <button id="btnPolygon" type="button" class="btn btn-primary btn-sm polygon-button">
                                <svg width="16" height="16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="draw-polygon" class="svg-inline--fa fa-draw-polygon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor" d="M96 151.4V360.6c9.7 5.6 17.8 13.7 23.4 23.4H328.6c0-.1 .1-.2 .1-.3l-4.5-7.9-32-56 0 0c-1.4 .1-2.8 .1-4.2 .1c-35.3 0-64-28.7-64-64s28.7-64 64-64c1.4 0 2.8 0 4.2 .1l0 0 32-56 4.5-7.9-.1-.3H119.4c-5.6 9.7-13.7 17.8-23.4 23.4zM384.3 352c35.2 .2 63.7 28.7 63.7 64c0 35.3-28.7 64-64 64c-23.7 0-44.4-12.9-55.4-32H119.4c-11.1 19.1-31.7 32-55.4 32c-35.3 0-64-28.7-64-64c0-23.7 12.9-44.4 32-55.4V151.4C12.9 140.4 0 119.7 0 96C0 60.7 28.7 32 64 32c23.7 0 44.4 12.9 55.4 32H328.6c11.1-19.1 31.7-32 55.4-32c35.3 0 64 28.7 64 64c0 35.3-28.5 63.8-63.7 64l-4.5 7.9-32 56-2.3 4c4.2 8.5 6.5 18 6.5 28.1s-2.3 19.6-6.5 28.1l2.3 4 32 56 4.5 7.9z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <div class="btn-group" role="group" aria-label="Group 2">
                            <button id="btnEdit" type="button" class="btn btn-primary btn-sm edit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502 .646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </button>
                            <button id="btnDelete" type="button" class="btn btn-primary btn-sm delete-button">
                                <svg width="16" height="16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="accordionExample">
                    <?php $index = 0; ?>
                    <?php foreach ($filter as $name => $geojson) : ?>
                        <?php if (count($geojson) > 0) : ?>
                            <div class="accordion-item accordionStyle">
                                <div class="accordion-header" id="heading<?= $index ?>">
                                    <div class="accordion-button collapsed d-flex justify-content-between align-items-center" style="height: 50px" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                        <div class="custom-text-style form-check" style="display: flex; align-items: center; gap: 10px;">
                                            <input type="checkbox" class="form-check-input px-1" id="checkbox<?= $index ?>" style="margin: 0;">
                                            <label class="form-check-label" style="margin: 0;"><?= $name ?></label>
                                        </div>
                                        <i class="bi bi-chevron-right mx-2"></i>
                                    </div>
                                </div>
                                <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>">
                                    <div class="accordion-body">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-0 small">
                                            <?php foreach ($geojson as $layer) : ?>
                                                <li class="btn-toggle-nav">
                                                    <div class="d-flex align-items-center custom-text-check form-check">
                                                        <input type="checkbox" class="form-check-input px-1" id="layer<?= $index ?>" value="<?= $layer->file ?>" data-filename="<?= $layer->file ?>">
                                                        <label class="form-check-label noselect link-dark rounded px-2">
                                                            <?= $layer->name ?>
                                                        </label>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php $index++; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div id="sideRight" class="sidebarRight" style="right: 0px; background-color:white;">
            <button id="sideToggle" class="btn btn-primary btn-sm tggl-button rightToggle" style="position:absolute; display:block; z-index:1000; right:250px; top:105px;">
                <i id="toggleIkon" class="fas fa-chevron-right"></i>
            </button>
            <div class="legend" id="legend" style="position:absolute; display:block; z-index:1000; right:260px; bottom:10px;"></div>
            <!-- Content for sidebarRight -->
            <div class="coordinateHeader">
                <div class="icon-container">
                    <!-- Replace the SVG icon with the provided icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg>
                    <span class="text p-1">-6.5569400, 107.4433300</span>
                </div>
            </div>
            <div class="flex-shrink-0 bg-white rightContent">
                <ul class="list-unstyled ps-0">
                    <li class="mb-1" style="margin: 0;">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                            <span class="custom-text-style">Statistik</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="collapse px-3 show" id="home-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li id="kecamatan"></li>
                                <li id="kelurahan"></li>
                                <li id="populasi"></li>
                                <li id="kepadatan_penduduk"></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                            <span class="custom-text-style">Informasi Zonasi</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="dashboard-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">Zona </li>
                                <p id="zona"></p>
                                <li class="link-dark rounded li-text">Sub Zona</li>
                                <p id="sub_zona"></p>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                            <span class="custom-text-style">Intensitas Bangunan</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="orders-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 16 16">
                                        <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5v-7zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3h-11zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0zm0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                            <span class="custom-text-style">Kegiatan Diizinkan</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="account-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 16 16">
                                        <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5v-7zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3h-11zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0zm0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#terbatas-collapse" aria-expanded="false">
                            <span class="custom-text-style">Kegiatan Terbatas</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="terbatas-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 16 16">
                                        <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5v-7zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3h-11zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0zm0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#bersyarat-collapse" aria-expanded="false">
                            <span class="custom-text-style">Kegiatan Bersyarat</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="bersyarat-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 16 16">
                                        <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5v-7zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3h-11zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0zm0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="reeQ d-flex justify-content-between align-items-center px-3 sub bg-soft-primary" data-bs-toggle="collapse" data-bs-target="#tbbersyarat-collapse" aria-expanded="false">
                            <span class="custom-text-style">Kegiatan Terbatas Bersyarat</span>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="collapse px-3" id="tbbersyarat-collapse">
                            <ul id="sideContent" class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="link-dark rounded li-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-textarea-resize" viewBox="0 0 16 16">
                                        <path d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5v-7zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3h-11zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0zm0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="map map-full rounded-top rounded-lg-start">
            <div id="maps"></div>
        </div>

    </div>

</div>
<?= script_tag("https://maps.googleapis.com/maps/api/js?key=" . $apiKey) ?>
<div class="bg-soft-primary d-flex justify-content-center align-items-center text-center" id="mobile-only" style="display: none !important;">
    <p>Halaman ini hanya bisa<br />bekerja di tampilan Desktop.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('lowerbody') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="<?= base_url('assets/js/L.switchBasemap.js') ?>"></script>
<script src="<?= base_url('uploads/geojson/Kecamatan.geojson') ?>"></script>
<script type="text/javascript">
    var $html = $('<div class="loading"><div class="uil-ring-css" style="transform: scale(0.79);"><div></div></div></div>');
    $('body').append($html);

    var BASE_URL = '<?= base_url() ?>';
    var API_KEY = '<?= session()->get('apikey') ?>';

    var map;
    var geojsonLayers = {};

    var initMap = function() {
        map = L.map('maps', {
            zoomDelta: 0.25,
            zoomSnap: 0,
            zoomControl: false
        }).setView([-6.5569400, 107.4433300], 12);

        map.addControl(new L.Control.Fullscreen({
            position: 'topleft'
        }));
        L.control.zoom({
            position: 'bottomleft'
        }).addTo(map);

        new L.basemapsSwitcher([{
                layer: L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map),
                icon: BASE_URL + '/assets/img/standar.jpg',
                name: 'OSM'
            },
            {
                layer: L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }),
                icon: BASE_URL + '/assets/img/street.jpg',
                name: 'Street'
            },
            {
                layer: L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }),
                icon: BASE_URL + '/assets/img/hybrid.jpg',
                name: 'Hybrid'
            },
            {
                layer: L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }),
                icon: BASE_URL + '/assets/img/terrain.jpg',
                name: 'Terrain'
            },
            {
                layer: L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }),
                icon: BASE_URL + '/assets/img/light.jpg',
                name: 'Light'
            },
        ], {
            position: 'topright'
        }).addTo(map);


        $('body > .loading').fadeOut();

        var activeLayers = [];
        var activeFeatures = [];


        function generatePopupContent(feature) {
            var popupContent = '';

            if (feature.properties.description && feature.properties.description.value) {
                popupContent += '<p>' + feature.properties?.description?.value || feature.properties?.name || "No description" + '</p>';
            } else if (feature.properties.name) {
                popupContent += '<p style="font-size:12px; font-weight:bold;">' + feature.properties.name + '</p>';
            }

            if (feature.properties.kecamatan) {
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Kecamatan : </span></br>' + feature.properties.kecamatan + '</p>';
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Luas Wilayah : </span></br>' + feature.properties.luas + '</p>';
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Jarak ke Ibukota Kecamatan : </span></br>' + feature.properties.jarak_ke_ibukota + ' km' + '</p>';
            }

            if (feature.properties.nama_pelaku_usaha) {
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Nama Pelaku Usaha : </span></br>' + feature.properties.nama_pelaku_usaha + '</p>';
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Alamat Usaha : </span></br>' + feature.properties.alamat_kantor + '</p>';
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Jenis Usaha : </span></br>' + feature.properties.judul_kbli_kegiatan_usaha + '</p>';
                popupContent += '<p style="font-size:12px"><span style="font-size:14px; font-weight:bold;">Luas Tanah : </span></br>' + feature.properties.luas_tanah + '</p>';
            }

            return popupContent;
        }



        function addLayerToMap(layer) {
            if (map && layer) {
                map.addLayer(layer);
                activeLayers.push(layer);
                activeFeatures.push(layer.feature);
                generateLegendContent(activeFeatures);
            }
        }

        function disableLayer(filename) {
            if (map && geojsonLayers[filename]) {
                map.removeLayer(geojsonLayers[filename]);
                var index = activeLayers.indexOf(geojsonLayers[filename]);
                if (index !== -1) {
                    activeLayers.splice(index, 1);
                    activeFeatures.splice(index, 1);
                    generateLegendContent(activeFeatures);

                    if (activeFeatures.length === 0) {
                        var legendDiv = document.getElementById('legend');
                        if (legendDiv) {
                            legendDiv.innerHTML = '';
                        }
                    }
                }
            }
        }


        function showLayer(feature, layer) {
            if (feature.geometry.type === "Polygon" || feature.properties) {
                var popupContent = generatePopupContent(feature);

                layer.bindPopup(popupContent);

                layer.on('click', function() {
                    showSidebar();
                    showDataInSidebar(feature, layer);
                });

                addLayerToMap(layer);
            } else if (feature.geometry.type === "LineString" || feature.properties) {
                var popupContent = generatePopupContent(feature);

                layer.bindPopup(popupContent);

                layer.on('click', function() {
                    showSidebar();
                    showDataInSidebar(feature, layer);
                });

                addLayerToMap(layer);
            } else if (feature.geometry.type === "Point") {
                // Handle marker layers
            } else {
                console.log("Type not found!");
            }
        }

        var geojsonLayer;

        function enableLayer(filename, targetLayerID) {
            if (geojsonLayers[filename]) {
                geojsonLayer = geojsonLayers[filename];
                geojsonLayer.addTo(map);
            } else {
                var target = BASE_URL + "/uploads/geojson/" + filename;
                fetch(target)
                    .then(response => response.json())
                    .then(geojsonData => {
                        geojsonLayer = L.geoJSON(geojsonData, {
                            style: function(feature) {
                                return {
                                    fillColor: feature.properties.fill,
                                    color: feature.properties.stroke,
                                    weight: feature.properties['stroke-width'] || 1,
                                    opacity: feature.properties['stroke-opacity'] || 1,
                                    fillOpacity: feature.properties['fill-opacity'] || 0
                                };
                            },
                            onEachFeature: function(feature, layer) {
                                if (feature.properties && feature.properties.id === targetLayerID) {
                                    showLayer(feature, layer);
                                }
                                layer.on('mouseover', function(e) {
                                    this.setStyle({
                                        fillColor: feature.properties.fill,
                                        fillOpacity: 0.7,
                                        weight: 4,
                                    });
                                });

                                layer.on('mouseout', function(e) {
                                    geojsonLayer.resetStyle(this);
                                });
                            }
                        });

                        geojsonLayer.addTo(map);
                        geojsonLayers[filename] = geojsonLayer;

                        var bounds = geojsonLayer.getBounds();
                        map.fitBounds(bounds);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }

        var layerFilter = document.getElementById('layer-filter');

        layerFilter.addEventListener('change', function() {
            var selectedKecamatan = layerFilter.value;
            filterLayer(selectedKecamatan);
        });

        function filterLayer(selectedKecamatan) {
            if (geojsonLayer) {
                map.removeLayer(geojsonLayer);
            }

            if (selectedKecamatan === 'all') {
                geojsonLayer.addTo(map);
            } else {
                geojsonLayer.eachLayer(function(layer) {
                    if (layer.feature.properties.kecamatan === selectedKecamatan) {
                        layer.addTo(map);
                    }
                });
            }
        }

        function showSidebar() {
            var sidebar = document.getElementById('sideRight');
            sidebar.style.display = 'block';
        }

        function showDataInSidebar(feature, layer) {
            var properties = feature.properties;
            var icon = 'Belum ada data';

            var kecamatanText = properties.kecamatan ? properties.kecamatan : (properties.lokasi_usaha ? properties.lokasi_usaha.kecamatan : icon);
            document.getElementById('kecamatan').innerHTML = '<li class="link-dark rounded li-text">Kecamatan :</li> <p>' + kecamatanText + '</p>';

            var kelurahanText = properties.kelurahan ? properties.kelurahan : (properties.lokasi_usaha ? properties.lokasi_usaha.kelurahan : icon);
            document.getElementById('kelurahan').innerHTML = '<li class="link-dark rounded li-text">Kelurahan :</li> <p>' + kelurahanText + '</p>';

            var populasiText = properties.populasi ? properties.populasi : (properties.status_penanaman_modal ? properties.status_penanaman_modal : '');
            var populasiLabel = properties.kepadatan_penduduk ? 'Populasi :' : (properties.status_penanaman_modal ? 'Status Penanaman Modal :' : '');
            document.getElementById('populasi').innerHTML = '<li class="link-dark rounded li-text">' + populasiLabel + '</li> <p>' + populasiText + '</p>';

            var kepadatanPendudukText = properties.kepadatan_penduduk ? properties.kepadatan_penduduk : (properties.skala_usaha ? properties.skala_usaha : '');
            var kepadatanPendudukLabel = properties.kepadatan_penduduk ? 'Kepadatan Penduduk :' : (properties.skala_usaha ? 'Skala Usaha :' : '');
            document.getElementById('kepadatan_penduduk').innerHTML = '<li class="link-dark rounded li-text">' + kepadatanPendudukLabel + '</li> <p>' + kepadatanPendudukText + '</p>';

            $('#home-collapse').addClass('show');
        }

        function generateLegendContent(features) {
            var legendDiv = document.getElementById('legend');
            var content = '<h8 class="p-1" style="font-weight: bold; color:black;">LEGENDA</h8>' +
                '<div style="margin-top:0px; width:100%; border-bottom: 1px solid #b8b8b8; opacity:0.5"></div>';

            var displayedTypes = {};

            for (var i = 0; i < features.length; i++) {
                var feature = features[i];

                if (feature.properties && (feature.properties.fill || feature.properties.stroke)) {
                    var layerName = feature.properties.name || feature.properties.nama || feature.properties.nama_pelaku_usaha;
                    var fillColor = feature.properties.fill || feature.properties.stroke;
                    var layerType = feature.geometry.type;

                    if (!displayedTypes[layerType]) {
                        content += '<p class="px-3" style="margin-top:7px; font-weight: bold; font-size:12px; color:black;">' + layerType + '</p>';
                        displayedTypes[layerType] = true;
                    }

                    content += '<p class="legend-item px-1" style="margin:10px; font-size:10px; color:black;">' +
                        '<span class="color-box px-1" style="background: ' + fillColor + '"></span>' + layerName + '</p>';
                }
            }

            if (legendDiv) {
                legendDiv.innerHTML = content;
            }
        }

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            position: 'bottomleft',
            draw: {
                marker: {
                    icon: customMarkerIcon
                },
                circle: false,
                rectangle: false,
                polyline: {
                    shapeOptions: {
                        color: '#3f78e0',
                        weight: 3,
                    },
                },
                polygon: {
                    shapeOptions: {
                        color: '#3f78e0',
                        fillColor: '#0080ff',
                        fillOpacity: 0.5,
                    },
                },
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
            },
        });
        map.addControl(drawControl);

        var customMarkerIcon = L.icon({
            iconUrl: 'icons/pin.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32],
            shadowUrl: '',
            shadowSize: [32, 32],
            shadowAnchor: [16, 32]
        });
        var CustomPolygon = L.Draw.Polygon.extend({
            options: {
                shapeOptions: {
                    color: '#3f78e0',
                    fillColor: '#0080ff',
                    fillOpacity: 0.5,
                },
            },
        });

        document.getElementById('btnMarkers').addEventListener('click', function() {

            map.off(L.Draw.Event.CREATED);


            map.on(L.Draw.Event.CREATED, function(e) {
                var layer = e.layer;


                var customPopupContent = "Latitude: " + layer.getLatLng().lat + "<br>Longitude: " + layer.getLatLng().lng;


                layer.bindPopup(customPopupContent).openPopup();


                drawnItems.addLayer(layer);
            });


            drawControl.setDrawingOptions({
                marker: {
                    icon: customMarkerIcon
                }
            });
            drawControl._toolbars.draw._modes.marker.handler.enable();
        });

        document.getElementById('btnPolyline').addEventListener('click', function() {

            map.off(L.Draw.Event.CREATED);


            map.on(L.Draw.Event.CREATED, function(e) {
                var layer = e.layer;
                var length = calculatePolylineLength(layer);
                layer.bindPopup("Length: " + length.toFixed(2) + " m").openPopup();
                drawnItems.addLayer(layer);
            });

            drawControl.setDrawingOptions({
                polyline: {
                    shapeOptions: {
                        color: '#3f78e0',
                        weight: 3,
                    },
                }
            });
            drawControl._toolbars.draw._modes.polyline.handler.enable();
        });


        function calculatePolylineLength(polyline) {
            var latlngs = polyline.getLatLngs();
            var length = 0;

            for (var i = 1; i < latlngs.length; i++) {
                length += latlngs[i - 1].distanceTo(latlngs[i]);
            }

            return length;
        }



        document.getElementById('btnPolygon').addEventListener('click', function() {

            map.off(L.Draw.Event.CREATED);


            map.on(L.Draw.Event.CREATED, function(e) {
                var layer = e.layer;


                var customPopupContent = "Area: " + L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]).toFixed(2) + " square meters";


                drawnItems.addLayer(layer);
                layer.bindPopup(customPopupContent).openPopup();
            });


            drawControl.setDrawingOptions({
                polygon: {
                    shapeOptions: {
                        color: '#3f78e0',
                        fillColor: '#0080ff',
                        fillOpacity: 0.5,
                    },
                },
            });
            drawControl._toolbars.draw._modes.polygon.handler.enable();
        });


        document.getElementById('btnEdit').addEventListener('click', function() {
            if (drawnItems.getLayers().length > 0) {

                drawnItems.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {

                        layer.dragging.enable();
                    } else if (layer instanceof L.Polyline || layer instanceof L.Polygon) {

                        layer.editing.enable();
                    }
                });
            }
        });


        document.getElementById('btnDelete').addEventListener('click', function() {
            drawnItems.clearLayers();
        });

        map.on('draw:created', function(e) {
            var layer = e.layer;
            drawnItems.addLayer(layer);
        });

        $(document).on("change", "[id^='checkbox']", function() {
            var checkboxId = $(this).attr("id");
            var index = checkboxId.replace("checkbox", "");

            var isChecked = $(this).is(":checked");

            $("#collapse" + index + " input[type=checkbox]").prop("checked", isChecked);

            $("#collapse" + index + " input[type=checkbox]").each(function() {
                var filename = $(this).data("filename");
                if (isChecked) {
                    enableLayer(filename);
                } else {
                    disableLayer(filename);
                }
            });
        });

        $(document).on("change", "[id^='layer']", function() {
            var checkboxId = $(this).attr("id");
            var index = checkboxId.replace("layer", "");

            var filename = $(this).data("filename");
            var isChecked = $(this).is(":checked");

            if (isChecked) {
                enableLayer(filename);
            } else {
                disableLayer(filename);
            }
        });
    };

    $(document).ready(function() {
        initMap();
    });
</script>

<?= $this->endSection() ?>