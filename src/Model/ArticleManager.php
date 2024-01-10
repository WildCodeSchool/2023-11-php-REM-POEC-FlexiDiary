<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'Articles';
    public function insert(array $article, string $date, string $image, int $idBlog): int
    {
        $query = "INSERT INTO " . self::TABLE . " (Title, Image, Content, Date, Visible, idBlog, idTag) 
        VALUES (:title, :image, :content, :date, :visible, :idBlog, :idTag)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $article['Title']);
        $statement->bindValue(':image', $image);
        $statement->bindValue(':content', $article['Content']);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':visible', $article['visibility']);
        $statement->bindValue('idBlog', $idBlog);
        $statement->bindValue('idTag', $article['tags']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Get all articles from one Blog.
     */
    public function selectAllFromOne(int $id): ?array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE idBlog=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
