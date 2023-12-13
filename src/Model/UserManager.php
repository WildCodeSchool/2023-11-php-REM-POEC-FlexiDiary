<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'users';
    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            " (`Name`, `Email`, `password`, `Picture`)
        VALUES (:name, :email, :password, :picture)");
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':name', $credentials['name']);
        $statement->bindValue(':picture', $credentials['image']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
