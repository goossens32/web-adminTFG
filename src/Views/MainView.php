<?php declare( strict_types=1 );

namespace src\Views;

use src\Views\BaseView;

class MainView extends BaseView
{

    public function setScripts( array $scriptsList) { $this->scriptsList=$scriptsList; }
    public function setServers( array $serversList) { $this->serversList=$serversList; }
    public function setUserData( array $userData)   { $this->userData=$userData ;}

    protected function prepare(): string
    {      
        return $this->engine->render( 'index.html', [
            'title'         => $this->title,
            'id'            => $_SESSION['usr_id'],
            'userData'      => $this->userData,
            'scriptsList'   => $this->scriptsList,
            'serversList'   => $this->serversList
        ] );
    }
}

