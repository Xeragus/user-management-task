<?php

// Could be polished to perfection, but refactor will be skipped to not go beyond 4 hours
// The code is not really DRY (look at index.php)

$app = require "./core/app.php";
require_once './core/csrf.php';

$searchTerm = trim($_GET['search_term'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Fetch data
$conditions = '';
if ($searchTerm !== '') {
    $escaped = BaseModel::escapeValue("$searchTerm%");
    $conditions = "WHERE city LIKE $escaped";
}
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
