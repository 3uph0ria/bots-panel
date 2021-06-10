<?php

//$start = microtime(true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/Database.php');
require_once('config.php');
$Database = new Database();

//$botUser = $Database->SelectBotUser(userLogin);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/simplevk/autoload.php'); // Подключение библиотеки

use DigitalStar\vk_api\VK_api as vk_api; // Основной класс
use DigitalStar\vk_api\VkApiException; // Обработка ошибок


$vk = vk_api::create(TOKEN, VERSION)->setConfirm(KEY);

$data = json_decode(file_get_contents('php://input')); //Получает и декодирует JSON пришедший из ВК

$vk->sendOK(); //Говорим vk, что мы приняли callback

$message = $data->object->message->text;
$peer_id = $data->object->message->peer_id;
if($message)
{
    $menuCommends = $Database->SelectUserMenuCommends(userId);

    if($message == 'test')
    {
        $vk->sendMessage($peer_id, 'good' );
    }



    for($i = 0; $i < Count($menuCommends); $i++)
    {
        if($message == $menuCommends[$i]['button_text']) $vk->sendMessage($peer_id, $menuCommends[$i]['value']);
        $commends[] = $vk->buttonText($menuCommends[$i]['button_text'], $menuCommends[$i]['color'], ['command' => 'btn_1']);
    }



    if($alert) $buttonMessage = $alert;
    else $buttonMessage = 'выберите действие';
    $vk->sendButton($peer_id, $buttonMessage, [$commends]);
}
