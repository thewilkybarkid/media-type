#!/usr/bin/env php
<?php

declare(strict_types=1);

use Symfony\Component\Filesystem\Filesystem;

require_once __DIR__.'/../vendor/autoload.php';

$filesystem = new Filesystem();

$target = __DIR__.'/../tests/cases';

$base = 'https://github.com/web-platform-tests/wpt/raw/master/';
$files = [
    'LICENSE.md',
    'mimesniff/mime-types/resources/generated-mime-types.json',
    'mimesniff/mime-types/resources/mime-types.json',
];

$filesystem->remove($target);

foreach ($files as $file) {
    $filesystem->copy("{$base}/${file}", "{$target}/".basename($file));
}
