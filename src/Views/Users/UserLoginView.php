<?php declare( strict_types=1 );

namespace src\Views\Users;

use src\Views\BaseView;
use Parsedown;

class UserLoginView extends BaseView
{
    protected function prepare(): string
    {
        return $this->engine->render( 'login.html', [
            'title' => $this->title,
        ] );
    }
}
