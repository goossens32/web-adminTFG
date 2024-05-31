<?php declare(strict_types=1);

namespace src\Controllers\Servers;

use src\Views\Servers\ServersEditView;
use src\Database\Repository\UserRepository;
// use Ping;


class ServersEditViewController 
{
    public function __invoke(): void
    {
        $usrID = $_SESSION['usr_id'];
        $serversList = (new UserRepository())->getServersByUsrID($usrID);

        // foreach ($serversList as &$server) {
        //     $server['is_active'] = $this->isServerActive($server['ser_ipAddress']);
        // }

        $template = new ServersEditView();
        $template->setTitle('Servers');
        $template->setServers($serversList);
        $template->render();
    }

    // private function isServerActive($ip): bool
    // {
    //     $ping = new Ping($ip);
    //     $latency = $ping->ping();

    //     return $latency !== null;
    // }
}
