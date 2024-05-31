<?php declare( strict_types=1 );

namespace src\Controllers\Users;

use src\Database\Repository\UserRepository;

class UserEditProcessController
{
    public function __invoke(): void {
        $adminCheckbox = isset($_POST['usr_admin']) && $_POST['usr_admin'] == 'on' ? 'S':'N';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
            $usrID = intval($_POST['usr_id']);
            $this->deleteItem($usrID);
        
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
            try {
                $usrID = intval($_POST['usr_id']);
                $data = [
                    "usr_id" => $usrID,
                    "usr_name" => $this->clearForm($_POST['usr_name']),
                    "usr_email" => $this->clearForm($_POST['usr_email']),
                    "usr_password" => $this->clearForm($_POST['usr_password']),
                    "usr_admin" => $adminCheckbox
                ];
    
                $res = (new UserRepository())->updateUserInfo($data);
                
                if ( $res ) {        
                    Header("Location: /configuration/userlist");
                    die;
                }
            } catch (\Throwable $err) {
                print_r($err);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_single_user'])) {
            try {
                $usrID = intval($_POST['usr_id']);
                $data = [
                    "usr_id" => $usrID,
                    "usr_name" => $this->clearForm($_POST['usr_name']),
                    "usr_email" => $this->clearForm($_POST['usr_email']),
                    "usr_password" => $this->clearForm($_POST['usr_password']),
                    "usr_admin" => $adminCheckbox
                ];
    
                $res = (new UserRepository())->updateUserInfo($data);
                
                if ( $res ) {        
                    echo("<script>window.top.location.href='/logout'</script>");
                    die;
                }
            } catch (\Throwable $err) {
                print_r($err);
            }

        } else {
            try {
                $data = [
                    "usr_name" => $this->clearForm($_POST['usr_name']),
                    "usr_email" => $this->clearForm($_POST['usr_email']),
                    "usr_password" => $this->clearForm($_POST['usr_password']),
                    "usr_admin" => $adminCheckbox
                ];
    
                $res = (new UserRepository())->registerUser($data);
                
                if ( $res ) {        
                    Header("Location: configuration/userlist");
                    die;
                }
            } catch (\Throwable $err) {
                print_r($err);
            }
        }
        
    }

    function deleteItem($id){
        $res = (new UserRepository()) -> deleteUser($id);
        if ($res) {
            header("Location: configuration/userlist");
            die;
        } else {
            echo("Ha habido un error al eliminar");
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