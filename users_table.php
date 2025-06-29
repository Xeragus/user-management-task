<?php

// Could be polished to perfection, but refactor will be skipped to not go beyond 4 hours
// The code is not really DRY (look at index.php)

$app = require "./core/app.php";
require_once './core/csrf.php';

$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Fetch data
$users = User::find($app->db, '*', [], ['id' => 'DESC'], [$offset, $perPage]);

$stmt = $app->db->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $stmt[0]['total'];
$totalPages = ceil($totalUsers / $perPage);
$csrfToken = getCsrfToken();

// Render just the table view
$app->renderPartial('partials/users_table', [
    'users' => $users,
    'page' => $page,
    'totalPages' => $totalPages,
    'csrfToken' => $csrfToken
]);
