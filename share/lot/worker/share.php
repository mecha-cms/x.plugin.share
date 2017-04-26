<?php

$path = isset($lot['path']) ? $lot['path'] : $url->path;
$state = Plugin::state('share');
$a = require PLUGIN . DS . 'share' . DS . 'lot' . DS . 'state' . DS . 'a.php';

$counter = $state['counter'];
$count = e(File::open(PAGE . DS . $path . DS . 'share.data')->read([]));

?>
<div class="share<?php echo ' share-' . implode(' share-', $state['style']); ?> p">
  <?php foreach ($state['list'] as $k): ?>
  <?php $v = is_string($k) && isset($a[$k]) ? $a[$k] : $k; ?>
  <?php $i = $counter && !empty($count[$k]) ? ' <b>' . $count[$k] . '</b>' : ""; ?>
  <?php echo HTML::a($v['i'] . ' <span>' . $v['title'] . $i . '</span>', $url . '/' . $state['path'] . $k . HTTP::query(['path' => $path]), isset($v['target']) ? $v['target'] : null, ['classes' => ['to:' . $k]]); ?>
  <?php endforeach; ?>
</div>