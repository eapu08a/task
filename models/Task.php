<?php

class Task
{
    //количество задач на странице
    const SHOW_BY_DEFAULT = 3;

    //получаем список задач
    public static function getTaskList($page = 1)
    {
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $db = Db::getConnection();
        $taskList = array();
        $result = $db->query('SELECT * FROM tasks ORDER BY id DESC LIMIT ' . self::SHOW_BY_DEFAULT . ' OFFSET ' . $offset);
        $i = 0;
        while ($row = $result->fetch()) {
            $taskList[$i]['id'] = $row['id'];
            $taskList[$i]['email'] = $row['email'];
            $taskList[$i]['author'] = $row['author'];
            $taskList[$i]['text'] = $row['text'];
            $taskList[$i]['status'] = $row['status'];
            $taskList[$i]['edit'] = $row['edit'];
            $i++;
        }
        return $taskList;
    }

    //получаем общее число задач для пагинации
    public static function getTotalTasks()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT count(id) AS count FROM tasks');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['count'];
    }

    //добавялем задачу
    public static function add($author, $text, $email)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO tasks (author, text, email) VALUES (:author, :text, :email)";
        $result = $db->prepare($sql);
        $result->bindParam(':author', $author, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
    }

    //редактируем задачу
    public static function edit($id, $text, $status, $edit = 0)
    {

        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        $task = $result->fetch();
        if ($task['text'] === $text) {
            $edit = 0;
        } else {
            $edit = 1;
        }

        if ($task['status'] == 1) {
            $status = 1;
        }

        $sql = "Update  tasks SET text = :text, status = :status, edit = :edit WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_STR);
        $result->bindParam(':edit', $edit, PDO::PARAM_STR);
        $result->execute();
    }

    //получаем отсортированные задачи
    public static function sorting($type, $page = 1,$sort)
    {
        $page = intval($page);
        $sortby = '';
        if ($sort == 0) {
            $sortby = ' DESC';
        } else if ($sort == 1) {
            $sortby = ' ASC';
        }

        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $db = Db::getConnection();
        $taskList = array();
        $result = $db->query('SELECT * FROM tasks ORDER BY ' . $type . $sortby.' LIMIT ' . self::SHOW_BY_DEFAULT . ' OFFSET ' . $offset);
        $i = 0;
        while ($row = $result->fetch()) {
            $taskList[$i]['id'] = $row['id'];
            $taskList[$i]['email'] = $row['email'];
            $taskList[$i]['author'] = $row['author'];
            $taskList[$i]['text'] = $row['text'];
            $taskList[$i]['status'] = $row['status'];
            $taskList[$i]['edit'] = $row['edit'];
            $i++;
        }
        return $taskList;
    }
}