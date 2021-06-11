<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

// Записываем в БД данные из формы
$Database->AddMenuCommend($_SESSION['userId'], $_POST['button_text'], $_POST['color'], $_POST['value']);


//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
