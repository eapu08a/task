<?php

class AdminController
{
    public function actionLogin()
    {
        $login = Helper::validHelper($_POST['login']);
        $password = Helper::validHelper($_POST['password']);
        $userId = Admin::checkUserData($login, $password);
        if ($userId) {
            $jsonData = array('status' => '1');
        } else {
            $jsonData = array('status' => '0', 'message' => 'Неверный пароль');
        }
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);

    }

    public function actionLogout()
    {
        session_start();
        unset($_SESSION['user']);
        header("location: /");
    }


}