<?php

class Admin
{
    public static function checkUserData($login, $password)
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM users WHERE login = :login AND password = :password";
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            $_SESSION['user'] = $user['id'];
            return $user;
        }
    }

    public static function checkLogged()
    {

        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /");
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }
}