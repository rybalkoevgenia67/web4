<?php

if (!function_exists('getDatabase')) {

    function getDatabase() {

        static $pdo = null;

        if ($pdo === null) {

            $host = 'localhost';
            $dbname = 'u82673';
            $user = 'u82673';
            $password = '4038561';

            try {

                $pdo = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $user,
                    $password
                );

                $pdo->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            } catch (PDOException $e) {

                die(
                    'Ошибка подключения: '
                    . $e->getMessage()
                );
            }
        }

        return $pdo;
    }
}