<?php
declare(strict_types = 1);
namespace Models;

class Users
{
    // TODO: passer en privé
    public $id = null;
    public $firstname;
    public $lastname;
    public $email;
    public $pwd;
    public $role = 1;
    public $status = 0;


    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function setPwd(string $pwd): void
    {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function setRole(int $role): int
    {
        $this->role = $role;
    }

    public function setStatus(int $status): int
    {
        $this->status = $status;
    }
}
