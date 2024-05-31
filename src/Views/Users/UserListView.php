<?php declare( strict_types=1 );

namespace src\Views\Users;

use src\Views\BaseView;
use Parsedown;

class UserListView extends BaseView
{

    public function setUserList( array $userList)   { $this->userList=$userList ;}
    public function setCurrentUser( $currentUserID)   { $this->currentUserID=$currentUserID ;}

    protected function prepare(): string
    {
        return $this->engine->render( 'user_list.html', [
            'title'         => $this->title,
            'userList'      => $this->userList,
            'currentUserID' => $this->currentUserID
        ] );
    }
}
