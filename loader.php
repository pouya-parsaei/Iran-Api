<?php
# cache constants
define('CACHE_DIR',__DIR__ . '/cache');
define('CACHE_ENABLED',0);

# Authorization constants
define('JWT_KEY','Pouya-1-Key-Test@IranProject34325435#$@');
define('JWT_ALG','HS256');

include_once 'vendor/autoload.php';
include_once 'App/iran.php';
spl_autoload_register(function ($class) {

    $class_file = __DIR__ . '/' . $class . '.php';
    if (!(file_exists($class_file) && is_readable($class_file)))
        die("Could not find $class");
    include_once $class_file;
});

// use  App\Services\CityService;
// use  App\Services\ProvinceService;
// use  App\Utilities\Response;

// new CityService;
// new provinceService;
// Response::respond([1, 23], 200);
