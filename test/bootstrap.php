<?php

$classLoader = require __DIR__ . '/../vendor/autoload.php';
$classLoader->addPsr4('Eloquent\Phony\\', __DIR__ . '/src');