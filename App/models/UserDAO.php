<?php

namespace App\Models;

use Exception;
use PDO;
use PDOException;

class UserDAO
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();
  }

  public function getUserById($id)
  {
    $query = "SELECT id, username, email, password FROM users WHERE id = :id";
    $stmt = $this->db->prepare($query);

    try {
      $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
      throw new Exception("Error getting user " . $e->getMessage());
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
      return null;
    }

    return new User($user['id'], $user['username'], $user['email'], $user['password']);
  }

  public function getAllUsers()
  {
    $query = "SELECT id, username, email, password FROM users";
    $stmt = $this->db->prepare($query);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Error getting users " . $e->getMessage());
    }

    $users = [];
    $fetchedUsers = $stmt->fetchAll();
    foreach ($fetchedUsers as $fetchedUser) {
      $user =
        new User($fetchedUser['id'], $fetchedUser['username'], $fetchedUser['email'], $fetchedUser['password']);
      $users[] = $user->toAssocArray();
    }

    return $users;
  }

  public function insertUser($username, $email, $password)
  {
    if (!isset($username) || $username === "") {
      throw new Exception("username invalid");
    }

    if (!isset($email) || $email === "") {
      throw new Exception("email invalid");
    }

    if (!isset($password) || $password === "") {
      throw new Exception("password invalid");
    }

    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $this->db->prepare($query);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
      $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword
      ]);
    } catch (PDOException $e) {
      throw new Exception("Error inserting user " . $e->getMessage());
    }

    $id = $this->db->lastInsertId('users_id_seq');
    if ($id) {
      return $id;
    }

    return null;
  }

  public function deleteUser($id)
  {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($query);

    try {
      $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
      throw new Exception("Error deleting user " . $e->getMessage());
    }

    return;
  }
}
