<?php

class MainController
{
    public function actionIndex($page = 1)
    {
        if (isset($_POST['type'])) {
            $_SESSION['type'] = $_POST['type'];
            $_SESSION['sort'] = $_POST['sort'];
            $type = $_SESSION['type'];
            $sort = $_SESSION['sort'];
        } else if ($_SESSION['type']) {
            $type = $_SESSION['type'];
            $sort = $_SESSION['sort'];
        } else {
            $type = 'author';
            $sort = '0';
        }
        $taskList = array();
        $taskList = Task::sorting($type, $page, $sort);
        $total = Task::getTotalTasks();
        $pagination = new Pagination($total, $page, Task::SHOW_BY_DEFAULT, 'page-');
        require_once(ROOT . '/views/task/index.php');


    }

    public function actionAdd()
    {
        $author = Helper::validHelper($_POST['author']);
        $task = Helper::validHelper($_POST['task']);
        $email = Helper::validHelper($_POST['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($author) < 1) {
                $jsonData = array('status' => '0', 'message' => 'Укажите имя автора');
            } else if (strlen($task) < 1){
                $jsonData = array('status' => '0', 'message' => 'Укажите текст задачи');
            } else {
                Task::add($author, $task, $email);
                $jsonData = array('status' => '1', 'message' => 'Задача успешно добавлена');
            }
        } else {
            $jsonData = array('status' => '0', 'message' => 'Укажите корректный email вида **@**.**');
        }
        echo json_encode($jsonData,JSON_UNESCAPED_UNICODE);
    }

    public function actionEdit()
    {
        if(!isset($_SESSION['user'])){
            $jsonData = array('status' => '2', 'message'=> 'Авторизуйтесь');
        } else {
            $task = Helper::validHelper($_POST['task']);
            if(strlen($task) < 1){
                $jsonData = array('status' => '0', 'message' => 'Укажите текст задачи');
            } else {
                Task::edit($_POST['id'], $task, $_POST['status']);
                $jsonData = array('status' => '1', 'message' => 'Задача успешно отредактирована');
            }
        }
        echo json_encode($jsonData,JSON_UNESCAPED_UNICODE);
    }

}