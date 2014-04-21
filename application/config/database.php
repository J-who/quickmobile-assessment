<?php

if (Kohana::$environment !== Kohana::DEVELOPMENT) {

        $db = require_once('database/production.default.php');
        return $db;

} else {

// Default to development
    $db = require_once('database/development.default.php');
    return $db;
}