<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Views\BaseView;
use src\Views\Users\UserLoginView;
use src\Database\Repository\UserRepository;

class UserLoginViewController
{


    public function __invoke(): void
    {   
        if(isset($_SESSION['usr_id']))
        {
            header('Location: /');
            die;
        }
        $template = new UserLoginView();
        $template->setTitle( 'Webadmin - Login' );
        $template->render();
        
    }

}
