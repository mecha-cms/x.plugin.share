<?php namespace _\route;

function share($form) {
    global $language;
    $state = \plugin('share');
    $a = \plugin('share:a');
    if (!isset($a[$id = $this[0]])) {
        $GLOBALS['t'][] = $language->isError;
        $this->view('404/share'); // Service does not exist
    }
    $path = $form['path'] ?? "";
    if (!$f = \File::exist([
        PAGE . DS . $path . '.page',
        PAGE . DS . $path . '.archive'
    ])) {
        $GLOBALS['t'][] = $language->isError;
        $this->view('404/share'); // Page does not exist
    }
    $page = new \Page($f);
    if (!empty($state['counter'])) {
        $data = $page['share'] ?? [];
        $data[$id] = ($data[$id] ?? 0) + 1;
        \File::set(json_encode($data))->saveTo(\Path::F($page->path) . DS . 'share.data', 0600);
    }
    if (isset($a[$id]['fn']) && \is_callable($a[$id]['fn'])) {
        $page = \fire($a[$id]['fn'], [], $page);
    }
    $v = $a[$id]['url'];
    if (\preg_match_all('#%[\w-]+\b#', $v, $m)) {
        foreach ($m[0] as $k) {
            $v = \str_replace($k, $page[\substr($k, 1)] ?? $k, $v);
        }
    }
    \Guard::kick($v);
}

\Route::set('share/to:*', __NAMESPACE__ . "\\share");