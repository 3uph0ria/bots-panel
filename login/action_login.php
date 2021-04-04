<?php
session_start();
spl_autoload_register(function ($class_name)
{
    include $_SERVER['DOCUMENT_ROOT'].'/bots-panel/include/classes/'.$class_name.'.php';
});

$Database = new Database();

// Получаем данные из формы
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

// Получаем данные о пользователях с таким же логином
$user = $Database->SelectBotUser($login);
$userPermissions = $Database->SelectBotPermissions($user['permission']);

// Проверяем соответствует ли пароль хешу
if (password_verify($password, $user['password'])) {

    $_SESSION['userId'] = $user['id'];
    $_SESSION['userLogin'] = $user['login'];
    $_SESSION['userVkId'] = $user['vk_id'];
    $_SESSION['firstName'] = $user['first_name'];
    $_SESSION['lastName'] = $user['last_name'];
    $_SESSION['namePermissions'] = $userPermissions['name_permissions'];
    $_SESSION['addNews'] = $userPermissions['add_news'];
    $_SESSION['addServer'] = $userPermissions['add_server'];
    header('Location: /bots-panel/');

} else {

    // Создаем сообщение и делаем редикрет
    $_SESSION['bedMessage'] = "Неверный логин или пароль";
    header('Location: /bots-panel/login/');
}
