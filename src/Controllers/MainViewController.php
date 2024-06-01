<?php declare( strict_types=1 );

namespace src\Controllers;

use src\Views\BaseView;
use src\Views\MainView;
use src\Database\Repository\UserRepository;

class MainViewController
{
    public function __invoke(): void
    {
        if (!isset($_SESSION['usr_id'])) {
            header("Location: /login");
            exit();
        } else {

            $usrID = $_SESSION['usr_id'];
            $userData = (new UserRepository())->getUserByID($usrID);
            $scriptsList = (new UserRepository())->getScriptsByUsrID($usrID);
            $serversList = (new UserRepository())->getServersByUsrID($usrID);
           
            $template = new MainView();
            $template->setTitle('Webadmin -'.' '.$userData['usr_name']);
            $template->setUserData($userData);
            $template->setScripts($scriptsList);
            $template->setServers($serversList);
            $template->render();
        } 
    }

}