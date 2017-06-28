<?php

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\CliMenuBuilder;

require_once(__DIR__ . '/../vendor/autoload.php');

$itemCallable = function (CliMenu $menu) {
    $menu->yesNo('Are you sure?', function ($res) {
            var_dump($res);
        })
        ->setYesText('OK')
        ->setNoText('Cancel')
        ->display();
};

$menu = (new CliMenuBuilder)
    ->setTitle('Basic CLI Menu')
    ->addItem('Delete Item', $itemCallable)
    ->addLineBreak('-')
    ->build();

$menu->open();
