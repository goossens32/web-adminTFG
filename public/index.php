<?php

// // IMPORT AREA
use src\Controllers\Users\UserLoginViewController;
use src\Controllers\Users\UserLoginProcessController;
use src\Controllers\Users\UserRegisterViewController;
use src\Controllers\Users\UserRegisterProcessController;
use src\Controllers\Users\UserLogoutController;
use src\Controllers\Users\UserEditViewController;
use src\Controllers\Users\UserListViewController;
use src\Controllers\Users\UserEditProcessController;
use src\Controllers\Scripts\ScriptProcessController;
use src\Controllers\Scripts\ScriptsEditViewController;
use src\Controllers\Servers\ServerProcessController;
use src\Controllers\Servers\ServersEditViewController;
use src\Controllers\Logs\LogsViewController;
use src\Controllers\UserConfigurationViewController;
use src\Controllers\MainViewController;
use src\Utils\FileSender;

use src\Database\Connection;
use src\Container;

// Link composer/autoload
require_once __DIR__ . '/../vendor/autoload.php';


// Twig loader to public part
$loader = new \Twig\Loader\FilesystemLoader('/var/www/web-admin/public');
$twig = new \Twig\Environment($loader);

session_save_path('/var/www/web-admin/sessions');
session_start();

if(!isset($_SESSION['usr_id'])){
    $_SESSION['usr_id'] = null;
}

define( "APP_PATH", dirname( __DIR__, 2 ) );

Container::service()->setConnection( new Connection() );

// APP ROUTES
$dispatcher = FastRoute\simpleDispatcher( function ( FastRoute\RouteCollector $r ) {

    if (!isset($_SESSION['usr_id']) || $_SESSION['usr_id'] === null) {
        $r->addRoute('GET', '/', UserLoginViewController::class);
    } else {
        $r -> addRoute( 'GET', '/main', MainViewController::class );
        $r -> addRoute( 'GET', '/login', UserLoginViewController::class );
        $r -> addRoute( 'GET', '/logout', UserLogoutController::class );
        // Configuration pages
        $r -> addRoute( 'GET', '/configuration', UserConfigurationViewController::class );
        $r -> addRoute( 'GET', '/configuration/user', UserEditViewController::class );
        $r -> addRoute( 'GET', '/configuration/scripts', ScriptsEditViewController::class );
        $r -> addRoute( 'GET', '/configuration/servers', ServersEditViewController::class );    
        $r -> addRoute( 'GET', '/configuration/userlist', UserListViewController::class );    
        $r -> addRoute( 'GET', '/configuration/logs', LogsViewController::class );    
    }
  

    // $r->addRoute('GET', '/register', UserRegisterViewController::class);

    // POST
    $r -> addRoute( 'POST', '/process_register', UserRegisterProcessController::class );
    $r -> addRoute( 'POST', '/process_login', UserLoginProcessController::class );
    $r -> addRoute( 'POST', '/update_user_info', UserEditProcessController::class );
    $r -> addRoute( 'POST', '/process_script', ScriptProcessController::class );
    $r -> addRoute( 'POST', '/process_server', ServerProcessController::class );
    $r -> addRoute( 'POST', '/file_sender', FileSender::class );

});



$uri = rawurldecode( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
$uri = $uri == '/' ? $uri : preg_replace( '/\/$/', '', $uri );

$routeInfo = $dispatcher->dispatch( $_SERVER['REQUEST_METHOD'], $uri );
switch ( $routeInfo[0] ) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        // ( new NotFoundView( '404 - La pagina que buscas no existe' ) )->render();
        break;
    
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405 - No permitido";
        print_r( $routeInfo );
        break;
    
    case FastRoute\Dispatcher::FOUND:
        call_user_func_array( new $routeInfo[1], $routeInfo[2] );
        break;
}
