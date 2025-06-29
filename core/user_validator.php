<?php

require_once __DIR__ . '/base_model.php'; // if needed for BaseModel::escapeValue

function validateUserInput($data, $db, $id = null) {
	$errors = [];

	$name = trim($data['name'] ?? '');
	$email = trim($data['email'] ?? '');
	$city = trim($data['city'] ?? '');
	$phone = trim($data['phone_number'] ?? '');

	// Required fields
	if ($name === '') $errors[] = 'Name is required.';
	if ($email === '') $errors[] = 'Email is required.';
	if ($city === '') $errors[] = 'City is required.';

	// Email format
	if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Invalid email format.';
	}

	// Phone: digits only, optional
	if ($phone && !preg_match('/^\d+$/', $phone)) {
		$errors[] = 'Phone number must contain only digits.';
	}

	// Email uniqueness
	$user = User::findFirst($db, '*', ['email' => $email]);

	if ($user && (!$id || $user->getId() != $id)) {
		$errors[] = 'Email already exists.';
	}

	return $errors;
}
