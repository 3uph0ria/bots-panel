<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

// Записываем в БД данные из формы
$Database->UpdProduct($_POST['id'], $_POST['name'], $_POST['cost'], $_POST['description']);


//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
