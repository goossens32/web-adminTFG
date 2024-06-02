<?php declare( strict_types=1 );

namespace src\Utils;
use src\Database\Repository\UserRepository;


class FileSender 
{
    public function __invoke(): void
    {
        function saveFileData () {
            try {
                // Get ID by option>select Form
                $selectedScriptID = $_POST['scriptSelect'];


                if (!isset($selectedScriptID)) {
                    print_r("No se ha recibido el ID correctamente");
                }
            
                if ($selectedScriptID !== null) {
                    $scriptData = (new UserRepository()) -> getScriptByID($selectedScriptID);

                    $tmpDir = "/tmp";
                    $tmpFileName = tempnam($tmpDir, 'script-');
                    $tmpFileContent = $scriptData['scr_content'];

                    $saveFile = file_put_contents($tmpFileName, $tmpFileContent);

                    $scrName = $scriptData['scr_name'].'.'.$scriptData['scr_type'];
                    return array('file' => $tmpFileName, 'name' => $scrName);
                }
        
            } catch (\Throwable $err) {
                print_r($err);
                echo('</br>');
            }
        }

        function getServerInfo () {
            try {
                $selectedServerID = $_POST['serverSelect'];

                if (!isset($selectedServerID)) {
                    print_r("No se ha recibido el ID correctamente");
                }

                if ($selectedServerID !== null) {
                    $serverInfo = (new UserRepository()) -> getServerByID($selectedServerID);
                    $serverIP = $serverInfo['ser_ipAddress'];

                    return $serverIP;
                }

            } catch (\Throwable $err) {
                print_r($err);
            }

        }

        function sendData($ip, $path, $name) {
            
            $conn = ssh2_connect($ip, 22);
            $mode = 0755;

            $user = $_POST['user'];
            $password = $_POST['password'];
            $remotePath = "/home/".$user."/";

            ssh2_auth_password($conn, $user, $password);
            ssh2_scp_send($conn, $path, $remotePath . $name, $mode);

        }

        function init() {
            try {
                $serverIP = getServerInfo();
                $fileData = saveFileData();
                $tmpFileName = $fileData['file'];
                $scrName = $fileData['name'];

                sendData($serverIP, $tmpFileName, $scrName);
                header("Location: /main");
            } catch (\Throwable $err) {
                print_r($err);
            }
        }
        
        init();
    }
    
}
