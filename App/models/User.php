<?php

namespace App\Models;

class User
{
  private $id;
  private $username;
  private $email;
  private $password;

  public function __construct($id, $username, $email, $password)
  {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function toAssocArray()
  {
    return [
      'id' => $this->id,
      'username' => $this->username,
      'email' => $this->email,
      'password' => $this->password,
    ];
  }
}
