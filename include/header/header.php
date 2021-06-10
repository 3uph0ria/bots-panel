<?php
session_start();
if(isset($_SESSION['userId']) == false)
{
    header('Location: /bots-panel/login/');
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/configs/project-config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/Database.php';
$Database = new Database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=PROJECT_NAME?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/bots-panel/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/bots-panel/dist/css/adminlte.min.css">
</head>

