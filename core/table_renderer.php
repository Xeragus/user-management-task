<?php

require_once './core/csrf.php';


function renderTablePartial($app, $page = 1, $perPage = 10) {
    $offset = ($page - 1) * $perPage;
    $csrfToken = getCsrfToken();

    $users = User::find($app->db, '*', [], ['id' => 'DESC'], [$offset, $perPage]);
    $stmt = $app->db->query("SELECT COUNT(*) AS total FROM users");
    $totalUsers = $stmt[0]['total'];
    $totalPages = ceil($totalUsers / $perPage);

    ob_start();
    $app->renderPartial('partials/users_table', [
        'users' => $users,
        'page' => $page,
        'totalPages' => $totalPages,
        'csrfToken' => $csrfToken
    ]);

    return ob_get_clean();
}
