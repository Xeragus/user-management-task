<?php

$app = require "./core/app.php";
require './core/table_renderer.php';
require './core/user_validator.php';
require_once './core/csrf.php';

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$errors = validateUserInput($_POST, $app->db);
if (!empty($errors)) {
	http_response_code(422);
	echo json_encode(['success' => false, 'errors' => $errors]);
	exit;
}

$user = new User($app->db);

$user->insert(array(
	'name' => $_POST['name'],
	'email' => $_POST['email'],
	'city' => $_POST['city'],
	'phone_number' => $_POST['phone_number']
));

echo json_encode([
    'success' => true,
    'html' => renderTablePartial($app)
]);

exit;
