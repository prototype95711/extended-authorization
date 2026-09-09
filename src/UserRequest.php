<?php

namespace AuthorizationSystem;

class UserRequest implements Interfaces\Unit
{
    private $objectData;

    private $userId;

    private $shemeMode;

    private $tableName = TABLE_PREFIX . TABLE_USERS;

    private $requestSheme = array(
        "registration" => array (
            "user_email" => array("alias" => "email", "title" => "Email"),
            "user_password" => array("alias" => "password", "title" => "Пароль"),
            "user_password_repeat" => array("alias" => "password_repeat", "title" => "Повтор пароля"),
            "user_first_name" => array("alias" => "first_name", "title" => "Имя"),
            "user_second_name" => array("alias" => "second_name", "title" => "Фамилия"),
            "user_type" => array("alias" => "utype", "title" => "Тип пользователя", "value" => UserTypes::USER)
        ),
        "login" => array (
            "user_email" => array("alias" => "email", "title" => "Email"),
            "user_password" => array("alias" => "password", "title" => "Пароль")
        ),
        "update" => array (
            "user_first_name" => array("alias" => "first_name", "title" => "Имя"),
            "user_second_name" => array("alias" => "second_name", "title" => "Фамилия")
        ),
        "update_password" => array (
            "user_password" => array("alias" => "password", "title" => "Пароль"),
            "user_password_repeat" => array("alias" => "password_repeat", "title" => "Повтор пароля"),
            "user_old_password" => array("alias" => "old_password", "title" => "Старый пароль")
        )
    );

    private $databaseSheme = array(
        "registration" => array (
            "user_email" => array("alias" => "email", "title" => "Email"),
            "user_password" => array("alias" => "password", "title" => "Пароль"),
            "user_first_name" => array("alias" => "first_name", "title" => "Имя"),
            "user_second_name" => array("alias" => "second_name", "title" => "Фамилия"),
            "user_type" => array("alias" => "utype", "title" => "Тип пользователя")
        ),
        "login" => array (
            "user_email" => array("alias" => "email", "title" => "Email"),
            "user_password" => array("alias" => "password", "title" => "Пароль")
        ),
        "update" => array (
            "user_first_name" => array("alias" => "first_name", "title" => "Имя"),
            "user_second_name" => array("alias" => "second_name", "title" => "Фамилия")
        ),
        "update_password" => array (
            "user_password" => array("alias" => "password", "title" => "Пароль")
        )
    );

    public function __construct($request, $shemeMode = "login") 
    {
        $this->setShemeMode($shemeMode);
        $data = $this->parseDataFromRequest($request);
        $this->setData($data);
    }

    public function getTableName() 
    {
        return $this->tableName;
    }

    public function getData() 
    {
        return $this->objectData;
    }

    public function getUserId() 
    {
        return $this->userId;
    }

    public function setUserId($userId) 
    {
        $this->userId = $userId;
    }
    
    public function prepareDataForDatabase() 
    {
        $data = $this->getData();
        $mode = $this->getShemeMode();
        $sheme = $this->getDatabaseSheme($mode);

        $requestData = array();

        if (isset($data["user_password"])) {
            $data["user_password"] = password_hash($data["user_password"], PASSWORD_BCRYPT);
        }

        foreach ($sheme as $key => $value) {
            
            $requestData[$key] = $data[$key];
        }

        return $requestData;
    }

    public function setError($errorText) 
    {
        throw new \Exception($errorText);
    }

    public function login()
    {
        $this->setShemeMode("login");
        $this->validateDataForLogin();
        $userId = $this->getUserId();
        
        try {

            $Session = new Session();
            $Session->create($userId);
    
        } catch (Exception $e) {
    
            $this->setError("Email или пароль неправильный! Попробуйте снова!");
        } 
    }

    public function update($userId)
    {
        $this->setShemeMode("update");
        $this->validateDataForUpdate();
        $data = $this->prepareDataForDatabase();
        
        $result = $this->updateUser($data, $userId);
    }

    public function updatePassword($userId)
    {
        $this->setShemeMode("update_password");
        $this->validateDataForPasswordUpdate($userId);
        $data = $this->prepareDataForDatabase();
        
        $result = $this->updateUser($data, $userId);
    }

    public function register()
    {
        $this->setShemeMode("registration");
        $this->validateDataForRegistration();
        $data = $this->prepareDataForDatabase();
        
        $result = $this->addUser($data);
    }

    private function parseDataFromRequest($request) 
    {
        $mode = $this->getShemeMode();
        $requestSheme = $this->getRequestSheme($mode);
        $data = array();

        foreach ($requestSheme as $key => $value) {

            if (isset($value["value"])) {
                $request[$value["alias"]] = $value["value"];
            }

            if (!isset($request[$value["alias"]])) {
                $this->setError("Поле {$value["title"]} пусто. Заполните все поля, помеченные звездочкой!");

                return false;
            }

            $data[$key] = $request[$value["alias"]];
        }

        return $data;
    }

    private function validateDataForUpdate() 
    {
        $data = $this->getData();
        $errors = '';

        if ($this->isFirstNameValid($data["user_first_name"]) === false) {
            $errors .= "Поле для имени пусто! Заполните все поля, помеченные звездочкой!<br>";
        }

        if ($this->isSecondNameValid($data["user_second_name"]) === false) {
            $errors .= "Поле для фамилии пусто! Заполните все поля, помеченные звездочкой!<br>";
        }

        if (!empty($errors)) {
            $this->setError($errors);
        }
    }

    private function validateDataForPasswordUpdate($userId) 
    {
        $data = $this->getData();
        $user = $this->getUser($userId);

        $errors = '';

        if ($this->isOldPasswordValid($data["user_old_password"], $user["user_password"]) === false) {
            $errors .= "Вы ввели неверный старый пароль! Попробуйте еще раз.<br>";
        }

        if ($this->isPasswordValid($data["user_password"]) === false) {
            $passwordMinLength = PASSWORD_MIN_LENGTH;
            $errors .= "Пароль не соответствует требованиям, он должен состоять как минимум из {$passwordMinLength} символов. Проверьте правильность введенного пароля!<br>";
        }

        if ($this->isPasswordRepeatValid($data["user_password"], $data["user_password_repeat"]) === false) {
            $errors .= "Пароли не совпадают! Проверьте правильность введенного пароля!<br>";
        }

        if (!empty($errors)) {
            $this->setError($errors);
        }
    }

    private function validateDataForLogin() 
    {
        $data = $this->getData();

        if ($this->isEmailValid($data["user_email"]) === false) {

            $this->setError("Пользователя с указанным Email-адресом не существует!");
        }

        if ($this->isUserExistByEmail($data["user_email"]) === false) {

            $this->setError("Пользователя с указанным Email-адресом не существует!");
        }

        if ($this->isPasswordValid($data["user_password"]) === false) {

            $this->setError("Введенный email или пароль неверен, попробуйте еще раз!");
        }

        if ($this->isUserExistByEmailAndPassword($data["user_email"], $data["user_password"]) === false) {

            $this->setError("Введенный email или пароль неверен, попробуйте еще раз!");
        }
    }

    private function validateDataForRegistration() 
    {
        $data = $this->getData();
        $errors = "";

        if ($this->isFirstNameValid($data["user_first_name"]) === false) {
            $errors .= "Поле для имени пусто! Заполните все поля, помеченные звездочкой!<br>";
        }

        if ($this->isSecondNameValid($data["user_second_name"]) === false) {
            $errors .= "Поле для фамилии пусто! Заполните все поля, помеченные звездочкой!<br>";
        }

        if ($this->isEmailValid($data["user_email"]) === false) {
            $errors .= "Email-адрес не соответствует требованиям!<br>";
        }

        if ($this->isUserExistByEmail($data["user_email"]) === true) {
            $errors .= "Пользователь с указанным Email-адресом уже существует!<br>";
        }

        if ($this->isPasswordValid($data["user_password"]) === false) {
            $passwordMinLength = PASSWORD_MIN_LENGTH;
            $errors .= "Пароль не соответствует требованиям, он должен состоять как минимум из {$passwordMinLength} символов. Проверьте правильность введенного пароля!<br>";
        }

        if ($this->isPasswordRepeatValid($data["user_password"], $data["user_password_repeat"])  === false) {
            $errors .= "Пароли не совпадают! Проверьте правильность введенного пароля!<br>";
        }

        if (!empty($errors)) {
            $this->setError($errors);
        }
    }

    private function isFirstNameValid($firstName) 
    {
        if (!empty(trim($firstName))) {

            return true;

        } else {
            return false;
        }
    }

    private function isSecondNameValid($secondName) 
    {
        if (!empty(trim($secondName))) {

            return true;

        } else {
            return false;
        }
    }

    private function isEmailValid($email) 
    {
        if (!empty(trim($email))) {

            if (strlen($email) >= EMAIL_MIN_LENGTH && strlen($email) <= EMAIL_MAX_LENGTH) {

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    return true;
                }
            }
        }
        
        return false;
    }

    private function isUserExistByEmail($email) 
    {
        $user = $this->getUserFromBaseByEmail($email);

        if (!empty($user)) {

            return true;
        }
        
        return false;
    }

    private function isUserExistByEmailAndPassword($email, $password) 
    {
        $user = $this->getUserFromBaseByEmail($email);

        if (!empty($user)) {

            if (isset($user["user_password"])) {

                if (password_verify($password, $user["user_password"]) === true) {
                    return true;
                }
            }
        }
        
        return false;
    }

    private function isPasswordValid($password) 
    {
        if (!empty(trim($password))) {

            if (strlen($password) >= PASSWORD_MIN_LENGTH) {

                return true;
            }
        }

        return false;
    }

    private function isPasswordRepeatValid($password, $passwordRepeat) 
    {
        if (!empty(trim($passwordRepeat))) {

            if ($passwordRepeat === $password) {
                return true;
            }
        }

        return false;
    }

    private function isOldPasswordValid($oldPassword, $userPassword)
    {
        if (password_verify($oldPassword, $userPassword) === true) {

            return true;
        }

        return false;
    }

    private function setShemeMode($shemeMode) 
    {
        $this->shemeMode = $shemeMode;
    }

    private function getShemeMode() 
    {
        return $this->shemeMode;
    }

    private function getDatabaseSheme($mode) 
    {
        return $this->databaseSheme[$mode];
    }

    private function setData($data) 
    {
        $this->objectData = $data;
    }

    private function getRequestSheme($mode) 
    {
        return $this->requestSheme[$mode];
    }

    private function getUserFromBaseByEmail($email) 
    {
        $table = $this->getTableName();
        $user = Database::getDb()->getRow("SELECT * FROM ?n WHERE user_email = ?s", $table, $email);

        $this->setUserId($user["id"]);

        return $user;
    }

    private function addUser($data) 
    {
        $table = $this->getTableName();
        $request = Database::getDb()->query("INSERT INTO ?n SET ?u", $table, $data);

        return $request;
    }

    private function updateUser($data, $userId) 
    {
        $table = $this->getTableName();
        $request = Database::getDb()->query("UPDATE ?n SET ?u WHERE id = ?i", $table, $data, (int) $userId);

        return $request;
    }

    private function getUser($userId) 
    {
        $table = $this->getTableName();
        $user = Database::getDb()->getRow("SELECT * FROM ?n WHERE id = ?i", $table, (int) $userId);

        return $user;
    }
}
