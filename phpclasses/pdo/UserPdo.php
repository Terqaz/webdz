<?php

require_once "PdoOrigin.php";

class UserPdo extends PdoOrigin
{
    public function isEmailExist($email)
    {
        $sql = 'SELECT COUNT(email) AS emails_count FROM `user` 
                WHERE email = :email';

        $emailsCount = $this->pdo->prepare($sql);
        $emailsCount->bindValue(':email', $email, PDO::PARAM_STR);
        $emailsCount->execute();
        $emailsCount = $emailsCount->fetch(PDO::FETCH_ASSOC);
        return $emailsCount['emails_count'] >= 1; // мб это массив с один элементом
    }

    public function save($user)
    {
        $sql = "INSERT INTO `user`(`id`, `name`, `email`, `phone`, `password_hash`) 
                VALUES (:id, :name, :email, :phone, :passwordHash)";

        $randomId = substr(uniqid('', true), 0, 8);

        $phone = implode(array_filter(
            str_split($user['phone']),
            function ($c) {
                return is_numeric($c);
            }
        ));
        $phone = substr($phone, 1, 10);

        $passwordHash = password_hash($user['password'], PASSWORD_DEFAULT);

        $insert = $this->pdo->prepare($sql);
        $insert->bindValue(':id', $randomId, PDO::PARAM_STR);
        $insert->bindValue(':name', $user['name'], PDO::PARAM_STR);
        $insert->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $insert->bindValue(':phone', $phone, PDO::PARAM_STR);
        $insert->bindValue(':passwordHash', $passwordHash, PDO::PARAM_STR);
        $insert->execute();

        return $randomId;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, name, password_hash FROM `user`
                WHERE email = :email";

        $user = $this->pdo->prepare($sql);
        $user->bindValue(':email', $email, PDO::PARAM_STR);
        $user->execute();

        return $user->fetch(PDO::FETCH_ASSOC);
    }
}
