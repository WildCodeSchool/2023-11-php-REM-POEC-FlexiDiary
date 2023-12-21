<?php

namespace App\Model;

use PDO;

class BlogsManager extends AbstractManager
{
    public const TABLE = 'Blogs';

    /**
     * Insert new item in database
     */
    public function insert(array $blog, string $dateCreationFormat, int $idUser): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (Title, Description, Date_creation, Visible, Background_color, Typo_title, idUsers) 
        VALUES (:Title, :Description, :Date_creation, :Visible, :Background_color, :Typotitle, :idUsers)");
        $statement->bindValue(':Title', $blog['Title'], PDO::PARAM_STR);
        $statement->bindValue(':Description', $blog['Description'], PDO::PARAM_STR);
        $statement->bindValue(':Date_creation', $dateCreationFormat, PDO::PARAM_STR);
        $statement->bindValue(':Visible', $blog['visibility'], PDO::PARAM_BOOL);
        $statement->bindValue(':Background_color', $blog['colorRef'], PDO::PARAM_STR);
        $statement->bindValue(':Typotitle', $blog['Typo-title'], PDO::PARAM_STR);
        $statement->bindValue(':idUsers', $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function update(array $item): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], PDO::PARAM_STR);

        return $statement->execute();
    }


    /**
     * Delete row form an ID
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE idBlog=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
