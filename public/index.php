<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;

/*
Register a loader 
*/
$loader = new Loader();
$loader->registerDirs(
	[
		"../app/controllers",
		"../app/models",
	]
);
$loader->register();

/*
Set Dependency Injection
*/
$di = new FactoryDefault();
/*Set view*/
$di->set("view", function() {
	$view = new View();
	$view->setViewsDir("../app/views");
	return $view;
});
/*Set url*/
$di->set("url", function() {
	$url = new UrlProvider();
	$url->setBaseUri("/first_phalcon_app/");
	return $url;
});
$di->set("db", function() {
	return new DbAdapter(
		[
			"host" => "localhost",
			"username" => "root",
			"password" => "",
			"dbname" => "recentlogin",
		]
	);
});
/*
Set session 
*/
$di->setShared(
    "session",
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);
/* Set Flash Message */
$di->set('flash', function() {
    $flash = new \Phalcon\Flash\Session(
    	[
    		"warning" => "warning",
    	]
    );
    return $flash;
});
/*
Create app
*/
$application = new Application($di);
try {
	$respon = $application->handle();
	$respon->send();
}
catch(Exception $e) {
	echo "Exception : ",$e->getMessage();
}

