<?php declare( strict_types=1 );

namespace src\Database\Repository;

use PDO;

class UserRepository extends BaseRepository
{
//    USERS FUNCTIONS ----------------------------------------------------------
    public function getUser ( string $user ): ? array {
        $stmt = $this->connection->get()->prepare( 'SELECT usr_id, usr_name, usr_email, usr_password, usr_admin FROM users WHERE usr_name = :usr_name' );
        $stmt->bindValue( ':usr_name', $user, PDO::PARAM_STR );
        $stmt->execute();
        
        return $stmt->fetch() ?: null;
    }

    public function getUserByID($id): ? array {
        $stmt = $this->connection->get()->prepare( 'SELECT usr_id, usr_name, usr_email, usr_password, usr_admin FROM users WHERE usr_id = :usr_id' );
        $stmt->bindValue( ':usr_id', $id, PDO::PARAM_INT );
        $stmt->execute();

        return $stmt->fetch() ?: null;
    
    }

    public function getUserID(string $user): ?int {
        $stmt = $this->connection->get()->prepare('SELECT usr_id FROM users WHERE usr_name = :usr_name');
        $stmt->bindValue(':usr_name', $user, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['usr_id'] : null;
    }

    public function loginUser ( $user, $password ) {
        $user = $this -> getUser( $user );

        if (!$user) { return null; }
        if (!password_verify ($password, $user['usr_password'])) { return null; }
        return [
            'usr_id'      => $user['usr_id'],
            'usr_name'    => $user['usr_name'],
            'usr_password'=> $user['usr_password'],
            'usr_admin'   => $user['usr_admin']
        ];
    }

    public function registerUser ( array $data ): bool {
        $stmt = $this->connection->get()->prepare('INSERT INTO users (usr_name, usr_email, usr_password, usr_admin) VALUES (:usr_name, :usr_email, :usr_password, :usr_admin)' );
        // Form params
        $stmt -> bindValue(':usr_name', $data['usr_name']); 
        $stmt -> bindValue(':usr_email', $data['usr_email']); 
        $stmt -> bindValue(':usr_password', password_hash( $data ['usr_password'], PASSWORD_DEFAULT )); 
        $stmt -> bindValue(':usr_admin', $data['usr_admin']);
        $stmt -> execute();
        
        return true;
    }

    public function deleteUser($id): bool {
        $stmt = $this->connection->get()->prepare('DELETE FROM users WHERE usr_id = :usr_id');
        $stmt -> bindValue(':usr_id', $id);
        $stmt -> execute();

        return true;
    }
    
    public function updateUserInfo (array $data): bool {
        $stmt = $this->connection->get()->prepare('UPDATE users SET usr_name = :usr_name, usr_email = :usr_email, usr_password = :usr_password, usr_admin = :usr_admin WHERE usr_id = :usr_id' );
        // Form params
        $stmt -> bindValue(':usr_id', $data['usr_id']); 
        $stmt -> bindValue(':usr_name', $data['usr_name']); 
        $stmt -> bindValue(':usr_email', $data['usr_email']); 
        $stmt -> bindValue(':usr_password', password_hash( $data ['usr_password'], PASSWORD_DEFAULT )); 
        $stmt -> bindValue(':usr_admin', $data['usr_admin']);
        $stmt -> execute();

        return true;
    }
    
    public function getUserList () : ? array {
        $stmt = $this->connection->get()->prepare('SELECT usr_id, usr_name, usr_email, usr_admin FROM users');
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

//    SCRIPTS FUNCTIONS ----------------------------------------------------------
    public function getScripts() : ? array {
        $stmt = $this->connection->get()->prepare( 'SELECT scr_id, scr_usr_id, scr_name, scr_description, scr_type, scr_content FROM scripts' );
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

    public function getScriptByID($id) : ? array {
        $stmt = $this->connection->get()->prepare( 'SELECT scr_id, scr_usr_id, scr_name, scr_description, scr_type, scr_content FROM scripts WHERE scr_id = :scr_id' );
        $stmt -> bindValue(':scr_id', $id);
        $stmt -> execute();
        
        return $stmt -> fetch() ?: [];
    }

    public function getScriptsByUsrID($id) : ? array {
        $stmt = $this->connection->get()->prepare( 'SELECT scr_id, scr_usr_id, scr_name, scr_description, scr_type, scr_content FROM scripts WHERE scr_usr_id = :scr_usr_id' );
        $stmt -> bindValue(':scr_usr_id', $id);
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

    public function uploadScript( array $data ): bool {
        $stmt = $this->connection->get()->prepare('INSERT INTO scripts (scr_usr_id, scr_name, scr_type, scr_content) VALUES (:scr_usr_id, :scr_name, :scr_type, :scr_content)');
        // Form params
        $stmt -> bindValue(':scr_usr_id', $data['scr_usr_id']);
        $stmt -> bindValue(':scr_name', $data['scr_name']);
        $stmt -> bindValue(':scr_type', $data['scr_type']);
        $stmt -> bindValue(':scr_content', $data['scr_content']);
        $stmt -> execute();

        return true;
    }

    public function deleteScript($id): bool {
        $stmt = $this->connection->get()->prepare('DELETE FROM scripts WHERE scr_id = :scr_id');
        $stmt -> bindValue(':scr_id', $id);
        $stmt -> execute();

        return true;
    }

    public function updateScript( array $data ): bool {
        $stmt = $this->connection->get()->prepare( 'UPDATE scripts SET scr_name = :scr_name, scr_type = :scr_type, scr_description = :scr_description, scr_content = :scr_content WHERE scr_id = :scr_id' );      
        $stmt -> bindValue(':scr_id', $data['scr_id']);
        $stmt -> bindValue(':scr_name', $data['scr_name']);
        $stmt -> bindValue(':scr_type', $data['scr_type']);
        $stmt -> bindValue(':scr_description', $data['scr_description']);
        $stmt -> bindValue(':scr_content', $data['scr_content']);
        $stmt -> execute();

        return true;
    }

//    SERVERS FUNCTIONS ----------------------------------------------------------
    public function getServers() : ? array {
        $stmt = $this->connection->get()->prepare('SELECT ser_id, ser_usr_id, ser_hostname, ser_ipAddress, ser_description, ser_pubKey FROM servers');
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

    public function getServerByID($id) : ? array {
        $stmt = $this->connection->get()->prepare('SELECT ser_id, ser_usr_id, ser_hostname, ser_ipAddress, ser_description, ser_pubKey FROM servers WHERE ser_id = :ser_id');
        $stmt -> bindValue(':ser_id', $id);
        $stmt -> execute();

        return $stmt -> fetch() ?: [];
    }

    public function getServersByUsrID($id) : ? array {
        $stmt = $this->connection->get()->prepare('SELECT ser_id, ser_usr_id, ser_hostname, ser_ipAddress, ser_description, ser_pubKey FROM servers WHERE ser_usr_id = :ser_usr_id');
        $stmt -> bindValue(':ser_usr_id', $id);
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

    public function addServer( array $data ): bool {
        $stmt = $this->connection->get()->prepare('INSERT INTO servers (ser_usr_id, ser_hostname, ser_ipAddress, ser_description) VALUES (:ser_usr_id, :ser_hostname, :ser_ipAddress, :ser_description)');
        // Form params
        $stmt -> bindValue(':ser_usr_id', $data['ser_usr_id']);
        $stmt -> bindValue(':ser_hostname', $data['ser_hostname']);
        $stmt -> bindValue(':ser_ipAddress', $data['ser_ipAddress']);
        $stmt -> bindValue(':ser_description', $data['ser_description']);
        $stmt -> execute();

        return true;
    }

    public function deleteServer($id): bool {
        $stmt = $this->connection->get()->prepare('DELETE FROM servers WHERE ser_id = :ser_id');
        $stmt -> bindValue(':ser_id', $id);
        $stmt -> execute();

        return true;
    }

    public function updateServer( array $data ): bool {
        $stmt = $this->connection->get()->prepare( 'UPDATE servers SET ser_hostname = :ser_hostname, ser_ipAddress = :ser_ipAddress, ser_description = :ser_description WHERE ser_id = :ser_id' );      
        $stmt -> bindValue(':ser_id', $data['ser_id']);
        $stmt -> bindValue(':ser_hostname', $data['ser_hostname']);
        $stmt -> bindValue(':ser_ipAddress', $data['ser_ipAddress']);
        $stmt -> bindValue(':ser_description', $data['ser_description']);
        $stmt -> execute();

        return true;
    }

//  LOGS FUNCTIONS
    public function getLogs() : ? array {
        $stmt = $this->connection->get()->prepare('SELECT u.usr_name, s.ser_hostname, x.scr_name, l.log_action, l.log_timestamp FROM logs l LEFT JOIN users u ON l.log_usr_id = u.usr_id LEFT JOIN servers s ON l.log_ser_id = s.ser_id LEFT JOIN scripts x ON l.log_scr_id = x.scr_id;');
        $stmt -> execute();

        return $stmt -> fetchAll() ?: [];
    }

}
