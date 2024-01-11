<?php

namespace App\Model;

use PDO;

class BlogsManager extends AbstractManager
{
    public const TABLE = 'Blogs';

        /**
     * Get just the first 3 from database.
     */
    public function select3(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        $query .= ' LIMIT 3';

        return $this->pdo->query($query)->fetchAll();
    }


    /**
     * Get one blog from database by ID.
     */
    public function selectOneBlogById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE idBlog=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Get alls blogs from database by ID User.
     */
    public function selectBlogsOfUser(int $idUser): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE idUsers=:id");
        $statement->bindValue('id', $idUser, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Insert new item in database
     */
    public function insert(array $blog, string $dateCreationFormat, int $idUser, string $image): int | bool
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (Title, Description, Date_creation, Visible, Background_color, Background_image, Typo_title, idUsers) 
        VALUES (:Title, :Description, :Date_creation, :Visible, :Background_color, :Background_image, :Typotitle, :idUsers)");
        $statement->bindValue(':Title', $blog['Title'], PDO::PARAM_STR);
        $statement->bindValue(':Description', $blog['Description'], PDO::PARAM_STR);
        $statement->bindValue(':Date_creation', $dateCreationFormat, PDO::PARAM_STR);
        $statement->bindValue(':Visible', $blog['visibility'], PDO::PARAM_BOOL);
        $statement->bindValue(':Background_color', $blog['colorRef'], PDO::PARAM_STR);
        $statement->bindValue(':Background_image', $image, PDO::PARAM_STR);
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
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE idBlog=:id");
        $statement->bindValue('id', $item['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], PDO::PARAM_STR);

        return $statement->execute();
    }


    /**
     * Delete row form an ID
     */
    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM Articles WHERE idBlog=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE idBlog=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
