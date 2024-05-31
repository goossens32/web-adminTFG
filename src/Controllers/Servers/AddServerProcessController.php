<?php declare( strict_types=1 );

// namespace src\Controllers\Servers;
// use src\Database\Repository\UserRepository;
// use src\Views\BaseView;
// use src\Views\MainView;

// class AddServerProcessController
// {
//     public function __invoke(): void
//     {
//         try {
//             $usrID = intval($_SESSION['usr_id']);

    

//             $data = [
//                 "ser_usr_id" => $usrID,
//                 "ser_hostname" => $this->clearForm($_POST['ser_hostname']),
//                 "ser_ipAddress" => $this->clearForm($_POST['ser_ipAddress']),
//                 "ser_description" => $this->clearForm($_POST['ser_description']),
//                 "ser_pubKey" => $this->clearForm($_POST['ser_pubKey'])
//             ];

//             $res = (new UserRepository()) -> addServer($data);

//             if ($res) {
//                 header("Location: /");
//                 die;
//             }
            
//         } catch (\Throwable $err) {
//             print_r($err);
//         }
//     }

//     // Clear form inputs
//     public function clearForm( $data )
//     {
//         $data = trim( $data );
//         $data = stripslashes( $data );
//         $data = htmlspecialchars( $data );
        
//         return $data;
//     }
// }