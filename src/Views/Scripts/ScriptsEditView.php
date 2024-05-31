<?php declare( strict_types=1 );

namespace src\Views\Scripts;

use src\Views\BaseView;
use Parsedown;

class ScriptsEditView extends BaseView
{

    public function setScripts( array $scriptsList) { $this->scriptsList=$scriptsList; }

    protected function prepare(): string
    {
        return $this->engine->render( 'user_scripts.html', [
            'title'         => $this->title,
            'scriptsList'   => $this->scriptsList
        ] );
    }
}
