<?php

require 'db.php';

$pdo = getDatabase();

$errors = [];
$values = [];

/* Поля формы */

$formFields = [
    'full_name',
    'phone',
    'email',
    'birth_date',
    'gender',
    'biography',
    'agreement',
    'languages'
];

/* Получаем сохранённые значения */

foreach ($formFields as $field) {

    if (isset($_COOKIE[$field])) {

        $values[$field] = $_COOKIE[$field];

    } else {

        $values[$field] = '';
    }
}

/* Получаем ошибки */

foreach ($formFields as $field) {

    $errorName = $field . '_error';

    if (isset($_COOKIE[$errorName])) {

        $errors[$field] =
            $_COOKIE[$errorName];

        /* Удаляем после использования */

        setcookie(
            $errorName,
            '',
            time() - 3600,
            '/'
        );
    }
}

/* Получаем языки из БД */

$stmt = $pdo->query("
    SELECT *
    FROM languages
    ORDER BY title
");

$languages = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);

/* Сообщение об успехе */

$successMessage = '';

if (isset($_COOKIE['success'])) {

    $successMessage =
        $_COOKIE['success'];

    setcookie(
        'success',
        '',
        time() - 3600,
        '/'
    );
}

/* Подключаем форму */

include 'form.php';

?>