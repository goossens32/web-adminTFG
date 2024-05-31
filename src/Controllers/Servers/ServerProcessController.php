<?php declare( strict_types=1 );

namespace src\Controllers\Servers;
use src\Database\Repository\UserRepository;
use src\Views\BaseView;
use src\Views\MainView;

class ServerProcessController
{
    public function __invoke(): void
    {
        try {
            $usrID = intval($_SESSION['usr_id']);
                    
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_server'])) {
                $serID = intval($_POST['ser_id']);
                $this->deleteItem($serID);
             
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_server'])) {
                $serID = intval($_POST['ser_id']);
                $data = [
                    'ser_id'            => $serID,
                    'ser_hostname'      => $_POST['ser_hostname'],
                    'ser_ipAddress'     => $_POST['ser_ipAddress'],
                    'ser_description'   => $_POST['ser_description']
                
                ]; $this->updateItem($data);
            
            } else {
                $data = [
                    "ser_usr_id" => $usrID,
                    "ser_hostname" => $this->clearForm($_POST['ser_hostname']),
                    "ser_ipAddress" => $this->clearForm($_POST['ser_ipAddress']),
                    "ser_description" => $this->clearForm($_POST['ser_description'])
                ];

                print_r($data);
    
                $res = (new UserRepository()) -> addServer($data);
    
                if ($res) {
                    header("Location: /main");
                    die;
                }
                
            }
            
        } catch (\Throwable $err) {
            print_r($err);
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

    function deleteItem($id){
        $res = (new UserRepository()) -> deleteServer($id);
        if ($res) {
            header("Location: configuration/servers");
            die;
        } else {
            echo("Ha habido un error al eliminar");
        }
    }

    function updateItem($data) {
        $res = (new UserRepository()) -> updateServer($data);
        if ($res) {
            header("Location: configuration/servers");
            die;
        } else {
            echo("Ha habido un error");
        }
    }
}
