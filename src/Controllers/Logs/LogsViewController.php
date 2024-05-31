<?php declare(strict_types=1);

namespace src\Controllers\Logs;

use src\Views\Logs\LogsView;
use src\Database\Repository\UserRepository;
// use Ping;


class LogsViewController
{
    public function __invoke(): void
    {
        $usrAdm = $_SESSION['usr_admin'];

        if ($usrAdm === 'N') {
            echo("Necesitas permisos de administrador var ver esta vista");
        
        } else {
            $logsList = (new UserRepository())->getLogs();
            $template = new LogsView();
            $template->setTitle('Logs');
            $template->setLogs($logsList);
            $template->render();
        } 

       
    }

    // private function isServerActive($ip): bool
    // {
    //     $ping = new Ping($ip);
    //     $latency = $ping->ping();

    //     return $latency !== null;
    // }
}