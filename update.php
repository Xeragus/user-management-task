<?php

$app = require './core/app.php';
require './core/table_renderer.php';
require './core/user_validator.php';
require_once './core/csrf.php';

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
  http_response_code(401);
  // Here you would also log the violation
  echo json_encode(['success' => false, 'message' => 'Error happened. Contact support.']);
  exit;
}

# should be refactored to improve readability, not gonna prioritize for now
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id'] ?? 0);

  $errors = validateUserInput($_POST, $app->db, $id);
  if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
  }

  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $city = $_POST['city'] ?? '';
  $phone = $_POST['phone_number'] ?? '';
  $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
  
  if ($id && $name && $email) {
    $user = new User($app->db, $id);

    $user->update([
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'phone_number' => $phone
    ]);

    echo json_encode([
      'success' => true,
      'html' => renderTablePartial($app, $page)
    ]);

    exit;
  }
}

http_response_code(400);
echo json_encode(['success' => false]);
