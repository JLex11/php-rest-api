<?php

namespace App\Controllers;

use App\Models\UserDAO;
use Exception;

class UserController
{
  private $userDAO;

  public function __construct()
  {
    $this->userDAO = new UserDAO();
  }

  public function getUser($id)
  {
    $user = null;

    try {
      $user = $this->userDAO->getUserById($id);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Internal error getting user']);
      return;
    }

    if (!$user) {
      http_response_code(404);
      echo json_encode(['error' => 'User not found']);
      return;
    }

    $response = json_encode($user);

    header('Content-Type: application/json');
    echo $response;
    return;
  }

  public function getAllUsers()
  {
    $users = [];

    try {
      $users = $this->userDAO->getAllUsers();
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Internal error getting all users']);
      return;
    }

    header('Content-Type: application/json');
    echo json_encode($users);
    return;
  }

  public function createUser()
  {
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$username || !$email || !$password) {
      http_response_code(400);
      echo json_encode(['error' => 'Username, email or password is missing']);
      return;
    }

    $insertedUserId = null;

    try {
      $insertedUserId = $this->userDAO->insertUser($username, $email, $password);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Internal error inserting user']);
      return;
    }

    if (!$insertedUserId) {
      http_response_code(500);
      echo json_encode(['error' => 'Could not insert user']);
      return;
    }

    header('Content-Type: application/json');
    echo json_encode(['id' => $insertedUserId]);
    return;
  }

  public function deleteUser($id)
  {
    try {
      $this->userDAO->deleteUser($id);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'Internal error deleting user']);
      return;
    }

    header('Content-Type: application/json');
    echo json_encode(['message' => 'User deleted successfully']);
    return;
  }
}
