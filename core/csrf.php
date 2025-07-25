<?php
// core/csrf.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($headerValue = null) {
    $token = $headerValue ?? '';

    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
