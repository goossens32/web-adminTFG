<?php declare( strict_types=1 );

namespace src\Views\Logs;

use src\Views\BaseView;
use Parsedown;

class LogsView extends BaseView
{

    public function setLogs( array $logsList)   { $this->logsList=$logsList;}

    protected function prepare(): string
    {
        return $this->engine->render( 'logs.html', [
            'title'         => $this->title,
            'logsList'      => $this->logsList,
        ] );
    }
}
