<?php

$state = Plugin::state('share');
Route::set($state['path'] . '%s%', function($id = "") use($site, $state, $url) {
    $id = urldecode($id);
    $a = require PLUGIN . DS . 'share' . DS . 'lot' . DS . 'state' . DS . 'a.php';
    if (!isset($a[$id]['url'])) {
        Shield::abort(); // Service does not exist
    }
    $path = Request::get('path');
    if (!$path || !$page = File::exist([
        PAGE . DS . $path . '.page',
        PAGE . DS . $path . '.archive'
    ])) {
        Shield::abort(); // Page does not exist
    }
    $f = PAGE . DS . $path . DS . 'share.data';
    $i = e(File::open($f)->read([]));
    $i[$id] = (isset($i[$id]) ? $i[$id] : 0) + 1;
    File::write(To::json($i))->saveTo($f, 0600);
    $page = Page::open($page)->get([
        'title' => $site->title,
        'description' => $site->description,
        'url' => $url . ""
    ]);
    foreach ($page as &$v) {
        $v = urlencode($v);
    }
    unset($v);
    if ($id === 'e-mail') {
        HTTP::header('Location', 'mailto:' . __replace__($a['e-mail']['url'], $page));
        exit;
    }
    Guardian::kick(__replace__($a[$id]['url'], $page));
});