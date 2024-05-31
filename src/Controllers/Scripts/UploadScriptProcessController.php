<?php declare( strict_types=1 );

// namespace src\Controllers\Scripts;
// use src\Database\Repository\UserRepository;
// use src\Views\BaseView;
// use src\Views\MainView;

// class UploadScriptProcessController
// {
//     public function __invoke():void
//     {
//         $usrID = $_SESSION['usr_id'];
        
//         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['script_file'])) {
//             $scr_name = $_FILES['script_file']['name'];
//             $scr_type = pathinfo($scr_name, PATHINFO_EXTENSION);
//             $scr_content = file_get_contents($_FILES['script_file']['tmp_name']);

//             try {
//                 echo($usrID); exit;

//                 $data = [
//                     'scr_usr_id' => $usrID,
//                     'scr_name' => $scr_name,
//                     'scr_type' => $scr_type,
//                     'scr_content' => $scr_content
//                 ];


//                 $res = (new UserRepository()) -> uploadScript($data);
//                 if ($res) { echo("Script subido"); header("Location: /"); }
//                 else {echo("Ha habido un error");}

//             } catch (\Throwable $err) {
//                 print_r($err);
//             }

//         }
//     }
// }
