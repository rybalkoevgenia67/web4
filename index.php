<?php

require_once 'db.php';

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

/* Загружаем сохранённые значения */

foreach ($formFields as $field) {

    $values[$field] =
        $_COOKIE[$field] ?? '';
}

/* Загружаем ошибки */

foreach ($formFields as $field) {

    $errorKey = $field . '_error';

    if (isset($_COOKIE[$errorKey])) {

        $errors[$field] =
            $_COOKIE[$errorKey];

        /* Удаляем cookie ошибки */

        setcookie(
            $errorKey,
            '',
            time() - 3600,
            '/'
        );
    }
}

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

/* Получаем языки */

$stmt = $pdo->query("
    SELECT *
    FROM languages
    ORDER BY title
");

$languages = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);

/* Подключаем форму */

include 'form.php';

?>