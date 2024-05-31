<?php declare( strict_types=1 );

namespace src\Controllers\Scripts;
use src\Database\Repository\UserRepository;
use src\Views\BaseView;
use src\Views\MainView;

class ScriptProcessController
{
    public function __invoke():void
    {
       
        try {
            $usrID = intval($_SESSION['usr_id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_script'])) {
                $scrID = intval($_POST['scr_id']);
                $this->deleteItem($scrID);
                
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_script'])) {
                $scrID = intval($_POST['scr_id']);
                $data = [
                    'scr_id' => $scrID,
                    'scr_name' => $_POST['scr_name'],
                    'scr_type' => $_POST['scr_type'],
                    'scr_description' => $_POST['scr_description'],
                    'scr_content' => $_POST['scr_content']
                
                ]; $this->updateItem($data);
    
            } else {
                $scr_FullName = $_FILES['script_file']['name'];
                $scr_name = substr($scr_FullName, 0, strpos($scr_FullName, '.'));
                $scr_type = pathinfo($scr_FullName, PATHINFO_EXTENSION);
                $scr_content = file_get_contents($_FILES['script_file']['tmp_name']);
                
                if ($usrID === null) {
                    echo "ID Usuario" . " " . $scrID . "<br>";
                    echo "Usuario no autenticado.";
                    return;
                }
                
                try {
                    $data = [
                        'scr_usr_id' => $usrID,
                        'scr_name' => $scr_name,
                        'scr_type' => $scr_type,
                        'scr_content' => $scr_content
                    ];
                    
                    // echo($scr_name); exit;

                    $res = (new UserRepository()) -> uploadScript($data);
                    if ($res) { echo("Script subido"); header("Location: /main"); }
                    else {echo("Ha habido un error");}
    
                } catch (\Throwable $err) {
                    print_r($err);
                }
            }
            
        } catch (\Throwable $err) {
            print_r($err);
        }
        
    }

    function deleteItem($id){
        $res = (new UserRepository()) -> deleteScript($id);
        if ($res) {
            header("Location: configuration/scripts");
            die;
        } else {
            echo("Ha habido un error al eliminar");
        }
    }

    function updateItem($data) {
        $res = (new UserRepository()) -> updateScript($data);
        if ($res) {
            header("Location: configuration/scripts");
            die;
        } else {
            echo("Ha habido un error");
        }
    }
}