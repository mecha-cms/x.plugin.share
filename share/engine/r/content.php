<?php

Content::set('share', File::exist([
    Content::$config['folder'] . DS . 'share.php',
    __DIR__ . DS . 'content' . DS . 'share.php'
]));