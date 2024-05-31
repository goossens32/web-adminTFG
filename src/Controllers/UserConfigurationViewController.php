<?php declare( strict_types=1 );

namespace src\Controllers;

use src\Views\BaseView;
use src\Views\UserConfigurationView;
use src\Database\Repository\UserRepository;

class UserConfigurationViewController
{
    public function __invoke(): void
    {
        $usrID = $_SESSION['usr_id'];
        $userData = (new UserRepository())->getUserByID($usrID);
        $template = new UserConfigurationView();
        $template->setUserData($userData);
        $template->setTitle('Configuración de usuario');
        $template->render();
    }
}