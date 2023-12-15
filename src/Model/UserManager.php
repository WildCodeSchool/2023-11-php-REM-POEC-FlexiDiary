<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'User';

    public function selectOneByEmail(string $email): array
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
