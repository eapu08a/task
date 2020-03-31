<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title></title>
</head>
<body>
<input type="hidden" id="sort" value="<?php echo $_SESSION['type']?>" sort="<?php echo $_SESSION['sort']?>">
<input type="hidden" id="page" value="<?php echo $page?>">
<ul class="nav justify-content-center">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" href="#">Добавить
            задачу</a>
    </li>
    <?php
    if (Admin::isGuest()) {
        echo '
           <li class="nav-item">
            <a class="nav-link active" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo" href="/">Войти в админ панель</a>
        </li>
        ';
    } else {
        echo '
         <li class="nav-item">
            <a class="nav-link active" href="/logout">Выход</a>
        </li>
        ';
    }
    ?>
</ul>
<form action="<?php echo '/page-' . $page; ?>" method="post">
    <div class="form-row align-items-center">
        <div class="col-auto my-1">
            <select id="sort_param" name="type" class="custom-select mr-sm-2">
                <option selected value="author" sort="0">по автору(по убыванию)</option>
                <option value="author" sort="1">по автору(по возрастанию)</option>
                <option value="email" sort="0">по емейлу(по убыванию)</option>
                <option value="email" sort="1">по емейлу(по возрастанию)</option>
                <option value="text" sort="0">по тексту(по убыванию)</option>
                <option value="text" sort="1">по тексту(по возрастанию)</option>
                <option value="status" sort="1">по статусу(по возрастанию)</option>
                <option value="status" sort="0">по статусу(по убыванию)</option>
            </select>
        </div>

        <div class="col-auto my-1">
            <input id="sorting" type="submit" name="submit" class="btn btn-primary" value="Сортировать">
        </div>
    </div>
</form>

<?php
if ((Admin::isGuest())) {
    foreach ($taskList as $task) {
        echo '
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <p class="display-6"> Автор: ' . $task['author'] . '</p>
                <p class="display-6"> email: ' . $task['email'] . '</p>
                <p class="lead"> Содержание задачи:' . $task['text'] . '</p>
                <p class="lead"> Статус:';
        if ($task['status'] == 0) {
            echo 'Не выполнено';
        } else {
            echo 'Выполнено';
        }
        echo '</p></div></div>';
    }
} else {
    foreach ($taskList as $task) {
        echo '
           <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <form action="/edit" method="post">
                    <p class="display-6"> Автор: ' . $task['author'] . '</p>
                    <p class="display-6"> email: ' . $task['email'] . '</p>
                    <p class="lead"> Содержание задачи:' . $task['text'] . '</p>
                    <input type="text" id="task' . $task['id'] . '" class="form-control" value="' . $task['text'] . '">';
        if ($task['status'] == 0) {
            echo '
                            <input type="checkbox" id="status' . $task['id'] . '" class="form-check-input"  value="1">
                            <label class="form-check-label" for="status' . $task['id'] . '">Отметить выполнение</label><br>
                            ';
        } else {
            echo '
                            <input type="checkbox" checked disabled id="status' . $task['id'] . '" class="form-check-input"  value="1">
                             <label class="form-check-label" for="status' . $task['id'] . '">выполнено</label><br>
                            ';
        }
        if ($task['edit'] == 1) {
            echo '<label class="form-check-label" for="exampleCheck">Редактировалось администратором</label><br>';
        }
        echo '
                               <input type="submit" id="' . $task['id'] . '" class="edit btn btn-primary" value="Применить"></form></div></div>
                             ';
    }
}
?>

<nav aria-label="Page navigation example">
    <?php echo $pagination->get(); ?>
</nav>
<!--  модалка добавления задачи-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление задачи</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/add" method="post">
                    <div class="form-group">
                        <label for="author" class="col-form-label">Автор:</label>
                        <input type="text" required name='author' class="form-control" id="author" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">email:</label>
                        <input type="email" name='email' required class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="task" class="col-form-label">Задача:</label>
                        <textarea name='text' class="form-control" id="task" required></textarea>
                    </div>
                    <input id="addTask" type="submit" name="submit" class="btn btn-primary" value="Создать задачу">
                </form>
            </div>
            <div class="modal-footer">


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вход</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin" method="post">
                    <div class="form-group">
                        <label for="login" class="col-form-label">Логин:</label>
                        <input type="text" name='login' class="form-control" id="login">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Пароль:</label>
                        <input type="password" name='password' class="form-control" id="password">
                    </div>
                    <input type="submit" id="enter" name="submit" class="btn btn-primary" value="Авторизация">
                </form>
            </div>
            <div class="modal-footer">


            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/views/task/index.js"></script>
</body>
</html>
