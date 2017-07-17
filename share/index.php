<?php

Asset::set(__DIR__ . DS . 'lot' . DS . 'asset' . DS . 'css' . DS . 'share.min.css');

function fn_share_path($path, $id) {
    if (is_string($id) && $id === 'share' && !$path) {
        return __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'share.php';
    }
    return $path;
}

Hook::set('shield.get.path', 'fn_share_path');

require __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'worker' . DS . 'route.php';