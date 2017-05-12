<?php
$app->detectEnvironment(function () use ($app) {
    //var_dump($app);exit();
    if( array_key_exists("HTTP_HOST", $_SERVER) ){
        if (!isset($_SERVER['HTTP_HOST'])) {
            /*Dotenv::load($app['path.base'], $app->environmentFile());*/

            $dotenv = new Dotenv\Dotenv($app['path.base'], $app->environmentFile());
            $dotenv->overload(); //this is important
        }

        $pos = mb_strpos($_SERVER['HTTP_HOST'], '.');
        $prefix = '';
        if ($pos) {
            $prefix = mb_substr($_SERVER['HTTP_HOST'], 0, $pos);
        }
        $file = '.' . $prefix . '.env';

        if (!file_exists($app['path.base'] . '/' . $file)) {
            $file = '.env';
        }

        //var_dump($app['path.base'] . '/' . $file);exit();
        //Dotenv::load($app['path.base'], $file);
        $dotenv = new Dotenv\Dotenv($app['path.base'], $file);
        $dotenv->overload(); //this is important

    }else{
        $file = '.env';
        $dotenv = new Dotenv\Dotenv($app['path.base'], $file);
        $dotenv->overload(); //this is important
    }
});
//var_dump(env("QUIEN_SOY"));exit();
///$dotenv = new Dotenv\Dotenv(__DIR__ . '/../', '.' . getenv('APP_ENV') . '.env');
//$dotenv->overload(); //this is important
