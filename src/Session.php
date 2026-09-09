<?php

namespace AuthorizationSystem;

class Session implements Interfaces\Unit
{
    private $objectData;

    private $tableName = TABLE_PREFIX . TABLE_LOGIN_SESSIONS;

    private $sessionSheme = array(
        "ip" => array("alias" => "ip"),
        "token_hash" => array("alias" => "hash"),
        "time_of_create" => array("alias" => "create_time"),
        "user_id" => array("alias" => "user")
    );

    public function __construct() 
    {
        $this->sessionInit();
    }

    public function read() 
    {
        $session = $this->parseDataFromSession();

        $this->setData($session);

        $sessionFromDb = $this->getSessionFromDatabase();

        if (!empty($sessionFromDb)) {

            if (sha1($session["token_hash"] . TOKEN_SALT) !== $sessionFromDb["token_hash"]) {

                $this->setError("Ключ сессии не соответствует сгенерированному!");
            }

        } else {
            $this->setError("Сессия не существует или уже просрочена!");
        }
    }

    public function create($userId) 
    {
        $this->setDataParam($userId, "user_id");
        
        $this->clear();

        $token = md5($userId . TOKEN_SALT . time());
        $ip = $this->getIp();
        $time = time();

        $this->setDataParam($token, "token_hash");
        $this->setDataParam($ip, "ip");
        $this->setDataParam($time, "time_of_create");

        $preparedForDatabase = $this->prepareDataForDatabase();
        $preparedForSession = $this->prepareDataForSession();

        $this->setSession($preparedForSession);
        $this->sendDataToDatabase($preparedForDatabase);

        $this->read();
    }

    public function clear() 
    {
        $data = $this->getData();

        $ip = $this->getIp();
        $userId = $data["user_id"] ?? 0;
        
        $this->removeDataInDatabaseByIpAndUserId($ip, $userId);
        $this->clearSession();
    }

    public function getTableName() 
    {
        return $this->tableName;
    }

    public function getData() 
    {
        return $this->objectData;
    }

    public function setData($data) 
    {
        $this->objectData = $data;
    }

    public function setDataParam($data, $param) 
    {
        $this->objectData[$param] = $data;
    }

    public function prepareDataForDatabase() 
    {
        $data = $this->getData();

        $requestData = array(
            "token_hash" => sha1($data["token_hash"] . TOKEN_SALT),
            "ip" => $data["ip"],
            "time_of_create" => date("Y-m-d H:i:s", $data["time_of_create"]),
            "user_id" => $data["user_id"]
        );

        return $requestData;
    }

    private function prepareDataForSession() 
    {
        $data = $this->getData();

        $requestData = array(
            "hash" => $data["token_hash"],
            "ip" => $data["ip"],
            "create_time" => $data["time_of_create"],
            "user" => $data["user_id"]
        );

        return $requestData;
    }

    private function sessionInit() 
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private function parseDataFromSession()
    {
        $session = $this->getSession();
        $sessionSheme = $this->getSessionSheme();
        $data = array();

        if (!empty($session)) {

            foreach ($sessionSheme as $key => $value) {

                if (!isset($session[$value["alias"]])) {
                    $this->setError("В сессии не хватает параметра {$value["alias"]}. Сессия будет очищена!");
    
                    return false;
                }
    
                $data[$key] = $session[$value["alias"]];
            }
    
            return $data;

        } else {

            $this->setError("Сессия пуста!");

            return false;
        }
    }

    private function sendDataToDatabase($data) 
    {
        $table = $this->getTableName();

        Database::getDb()->query("INSERT INTO ?n SET ?u", $table, $data);
    }

    private function removeDataInDatabaseByIpAndUserId($ip, $userId) 
    {
        $table = $this->getTableName();

        Database::getDb()->query("DELETE FROM ?n WHERE ip = ?s AND user_id = ?i", $table, $ip, $userId);
    }

    public function setError($errorText) 
    {
        $this->clear();
        throw new \Exception($errorText);
    }

    private function getIp() 
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {

            $ip = getenv('HTTP_X_FORWARDED_FOR');

        } elseif (getenv('HTTP_X_FORWARDED')) {

            $ip = getenv('HTTP_X_FORWARDED');

        } elseif (getenv('HTTP_CLIENT_IP')) {

            $ip = getenv('HTTP_CLIENT_IP');

        } elseif (getenv('REMOTE_ADDR')) {

            $ip = getenv('REMOTE_ADDR');

        } elseif (getenv('HTTP_FORWARDED')) {

            $ip = getenv('HTTP_FORWARDED');

        } elseif (getenv('HTTP_FORWARDED_FOR')) {

            $ip = getenv('HTTP_FORWARDED_FOR');

        } else {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    private function getSessionFromDatabase() 
    {
        $table = $this->getTableName();
        $data = $this->getData();
        $ip = $this->getIp();
        $expiretime = date("Y-m-d H:i:s" , time() - USER_SESSION_EXPIRETIME);
        $session = Database::getDb()->getRow("SELECT * FROM ?n WHERE ip = ?s AND user_id = ?i AND time_of_create > ?s", $table, $ip, $data["user_id"], $expiretime);

        return $session;
    }

    private function getSessionSheme() 
    {
        return $this->sessionSheme;
    }

    public function getSession()
    {
        $session = $_SESSION;
        $session = isset($session[USER_SESSION_ID]) ? $session[USER_SESSION_ID] : false;
        
        return $session;
    }

    private function setSession($data)
    {
        $_SESSION[USER_SESSION_ID] = $data;
    }

    private function clearSession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION[USER_SESSION_ID]);
        }
    }
}
