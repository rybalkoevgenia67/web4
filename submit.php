<?php

require 'db.php';

$pdo = getDatabase();

$errors = [];

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$birth_date = trim($_POST['birth_date'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$biography = trim($_POST['biography'] ?? '');
$agreement = isset($_POST['agreement']);
$languages = $_POST['languages'] ?? [];

/* ФИО */
if (
    empty($full_name) ||
    !preg_match('/^[а-яА-Яa-zA-Z\s\-]{1,150}$/u', $full_name)
) {

    $errors['full_name'] =
        'Допустимы только буквы, пробелы и дефис (до 150 символов)';
}

/* Телефон */
if (
    empty($phone) ||
    !preg_match('/^[0-9+\-\s\(\)]{5,30}$/', $phone)
) {

    $errors['phone'] =
        'Допустимы цифры, пробелы, +, -, скобки';
}

/* Email */
if (
    empty($email) ||
    !preg_match(
        '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
        $email
    )
) {

    $errors['email'] =
        'Введите корректный email';
}

/* Дата */
if (
    empty($birth_date) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date)
) {

    $errors['birth_date'] =
        'Введите корректную дату';
}

/* Пол */
if (
    !in_array($gender, ['male', 'female'])
) {

    $errors['gender'] =
        'Выберите пол';
}

/* Биография */
if (
    !empty($biography) &&
    !preg_match('/^[а-яА-Яa-zA-Z0-9\s.,!?()\-]*$/u', $biography)
) {

    $errors['biography'] =
        'Недопустимые символы в биографии';
}

/* Языки */
if (empty($languages)) {

    $errors['languages'] =
        'Выберите минимум один язык';
}

/* Контракт */
if (!$agreement) {

    $errors['agreement'] =
        'Необходимо согласиться';
}

/* Сохраняем значения */
setcookie(
    'full_name',
    $full_name,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'phone',
    $phone,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'email',
    $email,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'birth_date',
    $birth_date,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'gender',
    $gender,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'biography',
    $biography,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'agreement',
    $agreement,
    time() + 60 * 60 * 24 * 365
);

setcookie(
    'languages',
    json_encode($languages),
    time() + 60 * 60 * 24 * 365
);

/* Ошибки */
if (!empty($errors)) {

    foreach ($errors as $field => $error) {

        setcookie(
            $field . '_error',
            $error
        );
    }

    header('Location: index.php');

    exit();
}

/* Запись в БД */

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

    $applicationId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO application_language
        (
            application_id,
            language_id
        )
        VALUES (?, ?)
    ");

    foreach ($languages as $languageId) {

        $stmt->execute([
            $applicationId,
            $languageId
        ]);
    }

    $pdo->commit();

} catch (Exception $e) {

    $pdo->rollBack();
}

header('Location: index.php');
exit();