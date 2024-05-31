<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Database\Repository\UserRepository;

class UserRegisterProcessController
{
    public function __invoke(): void {

        $adminCheckbox = isset($_POST['usr_admin']) && $_POST['usr_admin'] == 'on' ? 'S':'N';
        
        try {
            $data = [
                "usr_name" => $this->clearForm($_POST['usr_name']),
                "usr_email" => $this->clearForm($_POST['usr_email']),
                "usr_password" => $this->clearForm($_POST['usr_password']),
                "usr_admin" => $adminCheckbox
            ];
            
            $res = (new UserRepository())->registerUser($data);
            
            if ( $res ) {
                header("Location: /main");
                print_r('Usuario registrado');
                die;
            }

        } catch (\Throwable $err) {
            print_r($err);
            print_r ($err->getMessage());
        }
    }

    // Clear form inputs
    public function clearForm( $data )
    {
        $data = trim( $data );
        $data = stripslashes( $data );
        $data = htmlspecialchars( $data );
        
        return $data;
    }
}
