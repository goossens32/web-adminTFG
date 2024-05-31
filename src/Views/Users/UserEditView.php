<?php declare( strict_types=1 );

namespace src\Views\Users;

use src\Views\BaseView;
use Parsedown;

class UserEditView extends BaseView
{

    public function setUserData( array $userData)   { $this->userData=$userData ;}

    protected function prepare(): string
    {
        return $this->engine->render( 'user_info.html', [
            'title'         => $this->title,
            'userData'      => $this->userData,
        ] );
    }
}
