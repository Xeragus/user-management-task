<?php

$app = require "./core/app.php";
require_once './core/csrf.php';

# Pagination not fully DRY, will skip a corner here to stay under 4h
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$users = User::find(
    $app->db,
    '*',
    [],
    ['id' => 'DESC'],
    [$offset, $perPage]
);
$totalUsers = $app->db->getCount();
$totalPages = ceil($totalUsers / $perPage);

$csrfToken = getCsrfToken();

$app->renderView('index', array(
	'users' => $users,
	'page' => $page,
	'totalPages' => $totalPages,
    'app' => $app,
    'csrfToken' => $csrfToken,
    'searchTerm' => ''
));
