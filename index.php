<?php

require_once './vendor/autoload.php';
require_once './config/config.php';

use App\Controllers\UserController;

$requestURI = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$relativeURI = str_replace(BASE_URL, '', $requestURI);

if ($relativeURI === '/' || $relativeURI === '/index.php') {
  require_once './App/views/home.php';
  exit();
}

if ($relativeURI === '/api/users') {
  $controller = new UserController();

  if ($requestMethod === 'POST') {
    $controller->createUser();
    exit();
  }

  $controller->getAllUsers();
  exit();
}

if (preg_match('/^\/api\/users\/(\d+)$/', $relativeURI, $matches)) {
  $userId = $matches[1];
  $controller = new UserController();

  if ($requestMethod === 'DELETE') {
    $controller->deleteUser($userId);
    exit();
  }

  $controller->getUser($userId);
  exit();
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
