<?php
session_start();

// Clear the order variables, then the rest of the session array.
unset($_SESSION['dessert'], $_SESSION['drink'], $_SESSION['drinkSize']);
$_SESSION = [];

// Expire the session ID cookie so the next visit starts a brand-new session.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

session_destroy();

// The lastVisit cookie is left alone: it only greets returning guests.
header('Location: index.php');
exit;
