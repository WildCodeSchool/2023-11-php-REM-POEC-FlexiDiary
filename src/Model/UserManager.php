<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'Users';
    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
        " (`Name`, `Email`, `Password`, `Picture`, `Role`)
        VALUES (:name, :email, :password, :picture, 'User')");
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':name', $credentials['name']);
        $statement->bindValue(':picture', $credentials['image']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByEmail(string $email): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE idUsers=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
