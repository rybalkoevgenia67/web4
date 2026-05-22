<?php

require_once 'db.php';

$pdo = getDatabase();

$errors = [];

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$birth_date = trim($_POST['birth_date'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$biography = trim($_POST['biography'] ?? '');

$agreement = isset($_POST['agreement']);

$languages =
    $_POST['languages'] ?? [];

if (
    empty($full_name) ||
    !preg_match(
        '/^[а-яА-Яa-zA-Z\s\-]{1,150}$/u',
        $full_name
    )
) {

    $errors['full_name'] =
        'Только буквы, пробелы и дефис';
}

if (
    empty($phone) ||
    !preg_match(
        '/^[0-9+\-\s()]{5,30}$/',
        $phone
    )
) {

    $errors['phone'] =
        'Допустимы цифры, +, -, пробелы';
}

if (
    empty($email) ||
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
) {

    $errors['email'] =
        'Введите корректный email';
}

if (
    empty($birth_date)
) {

    $errors['birth_date'] =
        'Выберите дату';
}

if (
    !in_array(
        $gender,
        ['male', 'female']
    )
) {

    $errors['gender'] =
        'Выберите пол';
}

if (
    empty($languages)
) {

    $errors['languages'] =
        'Выберите язык';
}

if (!$agreement) {

    $errors['agreement'] =
        'Необходимо согласиться';
}

/* cookies */

foreach ($_POST as $key => $value) {

    if (is_array($value)) {

        $value =
            json_encode($value);
    }

    setcookie(
        $key,
        $value,
        time() + 31536000,
        '/'
    );
}

/* ошибки */

if (!empty($errors)) {

    foreach (
        $errors as $field => $error
    ) {

        setcookie(
            $field . '_error',
            $error,
            0,
            '/'
        );
    }

    header(
        'Location: index.php'
    );

    exit();
}

/* сохранение */

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO applications
        (
            full_name,
            phone,
            email,
            birth_date,
            gender,
            biography,
            agreement
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $full_name,
        $phone,
        $email,
        $birth_date,
        $gender,
        $biography,
        $agreement ? 1 : 0
    ]);

    $applicationId =
        $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO
        application_language
        (
            application_id,
            language_id
        )
        VALUES (?, ?)
    ");

    foreach (
        $languages as $languageId
    ) {

        $stmt->execute([
            $applicationId,
            $languageId
        ]);
    }

    $pdo->commit();

    setcookie(
        'success',
        'Данные успешно сохранены!',
        0,
        '/'
    );

} catch (Exception $e) {

    $pdo->rollBack();
}

header('Location: index.php');
exit();