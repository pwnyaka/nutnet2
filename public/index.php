<?php

use app\engine\App;


$config = include realpath("../config/config.php");

require_once realpath("../vendor/autoload.php");

try {
    App::call()->run($config);
}
catch (\PDOException $exception) {
    echo $exception->getMessage();
}
catch (\Exception $exception) {
    echo $exception->getMessage() . "<br><br>";
    echo $exception->getTraceAsString();
}




