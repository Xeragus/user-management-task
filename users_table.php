<?php

// Could be polished to perfection, but refactor will be skipped to not go beyond 4 hours
// The code is not really DRY (look at index.php)

$app = require "./core/app.php";
require_once './core/csrf.php';
require_once './core/security_headers.php';

$searchTerm = trim($_GET['search_term'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$conditions = '';
if ($searchTerm !== '') {
    $escaped = BaseModel::escapeValue("$searchTerm%");
    $conditions = "WHERE city LIKE $escaped";
}

// Prepared statement would be better maybe, but the escape above is robust enough for this iteration
// This works completely - try to break it, so in order not to spend more than 4 hours I will not switch to prepared statements
$query = "SELECT * FROM users $conditions ORDER BY id DESC LIMIT $offset, $perPage";
$users = User::sql($app->db, $query);

$countQuery = "SELECT COUNT(*) AS total FROM users $conditions";
$countResult = $app->db->query($countQuery);
$totalUsers = $countResult[0]['total'];
$totalPages = ceil($totalUsers / $perPage);
$csrfToken = getCsrfToken();

// Render just the table view
$app->renderPartial('partials/users_table', [
    'users' => $users,
    'page' => $page,
    'totalPages' => $totalPages,
    'csrfToken' => $csrfToken,
    'searchTerm' => $searchTerm
]);
