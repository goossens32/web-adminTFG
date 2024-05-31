<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Views\BaseView;
use src\Views\Users\UserListView;
use src\Database\Repository\UserRepository;

class UserListViewController 
{
    public function __invoke(): void
    {
            $usrID = $_SESSION['usr_id'];
            $userList = (new UserRepository())->getUserList();

            $template = new UserListView();
            $template->setTitle('User');
            $template->setUserList($userList);
            $template->setCurrentUser($usrID);
            $template->render();
    }
}