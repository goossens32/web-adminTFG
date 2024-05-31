<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Views\BaseView;
use src\Views\Users\UserEditView;
use src\Database\Repository\UserRepository;

class UserEditViewController 
{
    public function __invoke(): void
    {
            $usrID = $_SESSION['usr_id'];
            $userData = (new UserRepository())->getUserByID($usrID);

            $template = new UserEditView();
            $template->setTitle('User');
            $template->setUserData($userData);
            $template->render();
    }
}