<?php declare( strict_types=1 );

namespace src\Controllers\Scripts;

use src\Views\BaseView;
use src\Views\Scripts\ScriptsEditView;
use src\Database\Repository\UserRepository;

class ScriptsEditViewController 
{
    public function __invoke(): void
    {
        $usrID = $_SESSION['usr_id'];
        $scriptsList = (new UserRepository())->getScriptsByUsrID($usrID);

        $template = new ScriptsEditView();
        $template->setTitle('Scripts');
        $template->setScripts($scriptsList);
        $template->render();
    }
}