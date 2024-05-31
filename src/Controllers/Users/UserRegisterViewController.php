<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Views\BaseView;
use src\Views\Users\UserRegisterView;
use src\Database\Repository\UserRepository;

class UserRegisterViewController
{
    public function __construct()
    {
    }

    public function __invoke(): void
    {        
        session_start();
        $template = new UserRegisterView();
        $template->setTitle('Registro');
        $template->render();
        
    }

}

