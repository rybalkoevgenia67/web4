<?php

require_once 'db.php';

$pdo = getDatabase();

$errors = [];
$values = [];

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

foreach ($formFields as $field) {

    $values[$field] =
        $_COOKIE[$field] ?? '';
}

foreach ($formFields as $field) {

    $errorKey = $field . '_error';

    if (isset($_COOKIE[$errorKey])) {

        $errors[$field] =
            $_COOKIE[$errorKey];

        setcookie(
            $errorKey,
            '',
            time() - 3600,
            '/'
        );
    }
}

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

$stmt = $pdo->query("
    SELECT *
    FROM languages
    ORDER BY title
");

$languages = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);

include 'form.php';