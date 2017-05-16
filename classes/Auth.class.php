<?php

namespace Auth;

class User
{
    private $id;
    private $username;
    private $db;
    private $user_id;

    private $db_host = "localhost";
    private $db_name = "Plan";
    private $db_user = "root";
    private $db_pass = "root";

    private $is_authorized = false;
	private $idRole = 0;
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->connectDb($this->db_name, $this->db_user, $this->db_pass, $this->db_host);
    }

    public function __destruct()
    {
        $this->db = null;
    }

    public static function isAuthorized()
    {
        if (!empty($_SESSION["user_id"])) {
            return (bool) $_SESSION["user_id"];
        }
        return false;
    }

    public function passwordHash($password, $salt = null, $iterations = 10)
    {
        $salt || $salt = uniqid();
        $hash = md5(md5($password . md5(sha1($salt))));

        for ($i = 0; $i < $iterations; ++$i) {
            $hash = md5(md5(sha1($hash)));
        }

        return array('hash' => $hash, 'salt' => $salt);
    }

    public function getSalt($username) {
        $query = "select salt from users where username = :username limit 1";
        $sth = $this->db->prepare($query);
        $sth->execute(
            array(
                ":username" => $username
            )
        );
        $row = $sth->fetch();
        if (!$row) {
            return false;
        }
        return $row["salt"];
    }

    public function authorize($username, $password, $remember=false)
    {
        $query = "select id, username, idRole from users where
            username = :username and password = :password limit 1";
        $sth = $this->db->prepare($query);
        $salt = $this->getSalt($username);

        if (!$salt) {
            return false;
        }

        $hashes = $this->passwordHash($password, $salt);
        $sth->execute(
            array(
                ":username" => $username,
                ":password" => $hashes['hash'],
            )
        );
        $this->user = $sth->fetch();
        
        if (!$this->user) {
            $this->is_authorized = false;
        } else {
            $this->is_authorized = true;
            $this->user_id = $this->user['id'];
			$this->idRole = $this->user['idRole'];
			$this->username = $this->user['username'];
            $this->saveSession($remember);
        }

        return $this->is_authorized;
    }

    public function logout()
    {
        if (!empty($_SESSION["user_id"])) {
            unset($_SESSION["user_id"]);
        }
    }

    public function saveSession($remember = false, $http_only = true, $days = 7)
    {
        $_SESSION["user_id"] = $this->user_id;
		$_SESSION["idRole"] = $this->idRole;
		$_SESSION["username"] = $this->username;
        if ($remember) {
            // Save session id in cookies
            $sid = session_id();

            $expire = time() + $days * 24 * 3600;
            $domain = ""; // default domain
            $secure = false;
            $path = "/";

            $cookie = setcookie("sid", $sid, $expire, $path, $domain, $secure, $http_only);
        }
    }

    public function create($username, $password, $idRole) {
        $user_exists = $this->getSalt($username);

        if ($user_exists) {
            throw new \Exception("User exists: " . $username, 1);
        }

        $query = "insert into users (username, password, idRole, salt)
            values (:username, :password, :idRole, :salt)";
        $hashes = $this->passwordHash($password);
        $sth = $this->db->prepare($query);

        try {
            $this->db->beginTransaction();
            $result = $sth->execute(
                array(
                    ':username' => $username,
                    ':password' => $hashes['hash'],
					':idRole' => $idRole,
                    ':salt' => $hashes['salt'],
                )
            );
            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollback();
            echo "Database error: " . $e->getMessage();
            die();
        }

        if (!$result) {
            $info = $sth->errorInfo();
            printf("Database error %d %s", $info[1], $info[2]);
            die();
        } 

        return $result;
    }

    public function connectdb($db_name, $db_user, $db_pass, $db_host = "localhost")
    {
        try {
            $this->db = new \pdo("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        } catch (\pdoexception $e) {
            echo "database error: " . $e->getmessage();
            die();
        }
        $this->db->query('set names utf8');

        return $this;
    }
	
	 public function change_password($username, $password)
{
    $user_exists = $this->getSalt($username);
    if (!$user_exists) {
        throw new \Exception("User doesn't exist: " . $username, 1);
    }

    $query = "update users set password = :password where username = :username";
    $salt = $this->getSalt($username);
    $hashes = $this->passwordHash($password, $salt);
    $sth = $this->db->prepare($query);

    $this->db->beginTransaction();
    $result = $sth->execute(  
        array( 
            ':username' => $username,
            ':password' => $hashes['hash'],
        )
    );

    $this->db->commit(); 
    $this->user = $sth->fetch();

    if (!$result) {
        $info = $sth->errorInfo();
        printf("Database w t f error %d %s", $info[1], $info[2]);
        die();
    } 
    return $result;     
}

public function getUsername($userid){
	  $query = "select username from users where
            id :id limit 1";
        $sth = $this->db->prepare($query);

        $sth->execute(
            array(
                ":id" => $userid,
            )
        );
        $this->user = $sth->fetch();
        
       /* if (!$this->user) {
            $this->is_authorized = false;
        } else {
            $this->is_authorized = true;
            $this->user_id = $this->user['id'];
			$this->rank = $this->user['rank'];
            $this->saveSession($remember);
        }*/

        return $this->username;
}
}
