<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["username"]) || !isset($_SESSION["status"])) {
    header("Location: pages/login.php");
    exit;
}

if (time() - $_SESSION["login_time"] > 300) {
    header("Location: pages/logout.php");
    exit;
}