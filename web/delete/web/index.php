<?php
// Init
error_reporting(NULL);
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/inc/main.php');

// Check token
if ((!isset($_GET['token'])) || ($_SESSION['token'] !== $_GET['token'])) {
    header('location: /login/');
    exit;
}

// Delete as someone else?
if (($_SESSION['userContext'] === 'admin') && (!empty($_GET['user']))) {
    $user = $_GET['user'];
}

if (!empty($_GET['domain'])) {
    $v_username = escapeshellarg($user);
    $v_domain = escapeshellarg($_GET['domain']);
    exec (HESTIA_CMD . 'v-delete-web-domain ' . $v_username . ' ' . $v_domain . " 'yes'", $output, $return_var);
    check_return_code($return_var, $output);
    unset($output);
}

$back = $_SESSION['back'];
if (!empty($back)) {
    header('Location: ' . $back);
    exit;
}

header('Location: /list/web/');
exit;
