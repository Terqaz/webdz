<?php

require_once "PdoOrigin.php";

class ScreenshotPdo extends PdoOrigin
{
    public function getScreenshots($lastId, $limit)
    {
        $isPrivate = 0;

        if ($lastId != '0') {
            $sql = 'SELECT id, creation_date, url FROM screenshot 
            WHERE id < :lastId && is_private=:isPrivate
            ORDER BY id DESC 
            LIMIT :lim';

            $screenshots = $this->pdo->prepare($sql);
            $screenshots->bindValue(':lastId', $lastId, PDO::PARAM_STR);
        } else { // First time getting
            $sql = 'SELECT id, creation_date, url FROM screenshot 
                    WHERE is_private=:isPrivate
                    ORDER BY id DESC 
                    LIMIT :lim';
            $screenshots = $this->pdo->prepare($sql);
        }
        $screenshots->bindValue(':isPrivate', $isPrivate, PDO::PARAM_BOOL);
        $screenshots->bindValue(':lim', $limit, PDO::PARAM_INT);
        $screenshots->execute();

        return $screenshots;
    }

    public function getScreenshot($id)
    {
        $sql = 'SELECT id, creation_date, url FROM screenshot 
                WHERE id = :id';

        $screenshot = $this->pdo->prepare($sql);
        $screenshot->bindValue(':id', $id, PDO::PARAM_STR);
        $screenshot->execute();

        return $screenshot;
    }
}
