<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Views\BaseView;
use src\Views\Users\LoginView;
use src\Database\Repository\UserRepository;



class UserLogoutController
{
    public function __construct()
    {
    }

    public function __invoke(): void
    {
     
        session_unset();
        session_destroy();

        header('Location: /');
        
    }

}