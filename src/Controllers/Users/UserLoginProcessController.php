<?php declare( strict_types=1 );

namespace src\Controllers\Users;
use src\Database\Repository\UserRepository;
use src\Views\BaseView;
use src\Views\MainView;
use src\Views\Users\UserLoginView;

class UserLoginProcessController
{
    public function __invoke(): void
    {
        $validUser = ( new UserRepository() )->loginUser( $_POST['usr_name'], $_POST['usr_password'] );

        try {

            if ( $validUser ) {
                $_SESSION['usr_id'] = $validUser['usr_id'];
                $_SESSION['usr_name'] = $validUser['usr_name'];
                $_SESSION['usr_admin'] = $validUser['usr_admin'];
                
                header("Location: /main"); 
                exit;

            } else {
                print_r( "Credenciales incorrectas" );
            }

        } catch (\Throwable $err) {
            print_r($err);
        }

    }
}
