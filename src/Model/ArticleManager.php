<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'Articles';
    public function insert(array $article): int
    {
        $query = "INSERT INTO " . self::TABLE . " () VALUES ()";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('', $article['']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
