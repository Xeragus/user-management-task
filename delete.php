<?php

$app = require './core/app.php';
require './core/table_renderer.php';
require_once './core/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
  }

  $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
  $perPage = 10;
  $id = intval($_POST['id']);

  $user = new User($app->db, $id);
  $user->delete();

  // Count users after deletion
  $stmt = $app->db->query("SELECT COUNT(*) AS total FROM users");
  $totalUsers = $stmt[0]['total'];
  $maxPages = max(1, ceil($totalUsers / $perPage));

  // Ensure the requested page isn't higher than max
  $page = min($page, $maxPages);

  echo json_encode([
      'success' => true,
      'html' => renderTablePartial($app, $page)
  ]);
  exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Invalid request']);
