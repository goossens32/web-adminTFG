<?php declare( strict_types=1 );

namespace src\Views;

use src\Views\BaseView;
use Parsedown;

class UserConfigurationView extends BaseView
{
    public function setUserData( array $userData)   { $this->userData=$userData ;}

    protected function prepare(): string
    {
        return $this->engine->render( 'user_dashboard.html', [
            'title'         => $this->title,
            'id'            => $_SESSION['usr_id'],
            'userData'      => $this->userData
        ] );
    }
}
