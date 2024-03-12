<?php

$required_app_files = array(
    __DIR__ . '/resources/prefix.php',
    __DIR__ . '/resources/countries.php',
    __DIR__ . '/controller.php',
);

// ----------------------REQUIRE APP FILES--------------------

foreach ($required_app_files as $app_file) {

    require_once($app_file);

}
