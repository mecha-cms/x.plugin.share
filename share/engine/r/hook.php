<?php namespace _\share;

function svg($content) {
    $a = \plugin('share:a');
    $out = '<svg display="none" id="svg:share" xmlns="http://www.w3.org/2000/svg">';
    foreach ($a as $k => $v) {
        if (isset($v['icon'])) {
            $id = \dechex(\crc32('share:' . $k . \json_encode($v['icon'])));
            $out .= '<symbol id="i:' . $id . '" viewBox="' . ($v['icon'][1] ?? '0 0 24 24') . '"><path d="' . $v['icon'][0] . '"></path></symbol>';
        }
    }
    $out .= '</svg>';
    return \strpos($content, '<body>') !== false ? \str_replace('<body>', '<body>' . $out, $content) : \preg_replace('<body(\s[^>]*)?>', '<body$1>' . $out, $content);
}

\Hook::set('content', __NAMESPACE__ . "\\svg");