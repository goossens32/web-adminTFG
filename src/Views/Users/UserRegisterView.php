<?php declare( strict_types=1 );

namespace src\Views\Users;

use src\Views\BaseView;
use Parsedown;

class UserRegisterView extends BaseView
{
    protected function prepare(): string
    {
        return $this->engine->render( 'user_register.html', [
            'title' => $this->title,
        ] );
    }
}
