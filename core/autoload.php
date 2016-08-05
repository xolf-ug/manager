<?php

$system = ['fpdf', 'Pdf', 'Manager','Setting','Setup'];

$storage = ['Navigation'];

require __DIR__ . '/../vendor/autoload.php';

foreach ($storage as $file) {
    require  __DIR__ . '/storage/' . $file . '.php';
}

foreach ($system as $file) {
    require  __DIR__ . '/' . $file . '.php';
}