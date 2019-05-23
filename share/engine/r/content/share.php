<?php

$state = array_replace(plugin('share'), $lot);
$path = trim($state['path'] ?? $url->path, '/');
$a = plugin('share:a');

$counter = !empty($state['counter']);
$count = Page::open(File::exist([
    PAGE . DS . $path . '.page',
    PAGE . DS . $path . '.archive',
]))['share'];

// `static::share(['facebook', 'twitter'])`
if (Is::anemon_0($lot)) {
    $state['list'] = $lot;
}

?>
<?php if (!empty($state['list'])): ?>
<span class="share<?php echo ' share-' . implode(' share-', $state['style']); ?>">
  <?php foreach ($state['list'] as $k): ?>
  <?php $v = is_string($k) && isset($a[$k]) ? $a[$k] : $k; ?>
  <?php $id = dechex(crc32('share:' . $k . json_encode($v['icon'] ?? []))); ?>
  <?php $i = $counter && !empty($count[$k]) ? ' <b>' . $count[$k] . '</b>' : ""; ?>
  <a class="to:<?php echo $k; ?>" href="<?php echo $url . '/share/to:' . $k . $url->query('&amp;', ['path' => $path]); ?>" target="<?php echo $v['target'] ?? '_self'; ?>" title="<?php echo $v['description'] ?? Language::get('do-share-' . $k); ?>"><svg><use href="#i:<?php echo $id; ?>"></use></svg> <span><?php echo trim(($v['title'] ?? To::title($k)) . $i); ?></span></svg></a>
  <?php endforeach; ?>
</span>
<?php endif; ?>