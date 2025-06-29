<?php

$app = require './core/app.php';
require_once './core/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
  }

  $id = intval($_POST['id']);

  # Add validation

  // Find the user and delete
  $user = new User($app->db, $id);
  $user->delete();

  echo json_encode(['success' => true]);
  exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Invalid request']);
