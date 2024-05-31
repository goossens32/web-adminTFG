<?php declare( strict_types=1 );

namespace src\Views\Servers;

use src\Views\BaseView;
use Parsedown;

class ServersEditView extends BaseView
{
    public function setServers( array $serversList) { $this->serversList=$serversList; }

    protected function prepare(): string
    {
        return $this->engine->render( 'user_servers.html', [
            'title'         => $this->title,
            'serversList'   => $this->serversList
        ] );
    }
}
