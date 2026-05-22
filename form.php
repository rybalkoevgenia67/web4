<?php

require 'db.php';

$pdo = getDatabase();

$stmt = $pdo->query("
    SELECT
        a.*,
        GROUP_CONCAT(
            l.title
            SEPARATOR ', '
        ) AS languages

    FROM applications a

    LEFT JOIN application_language al
        ON a.id = al.application_id

    LEFT JOIN languages l
        ON l.id = al.language_id

    GROUP BY a.id

    ORDER BY a.id DESC
");

$applications = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Сохранённые заявки</title>

<link rel="stylesheet"
      href="style.css">

</head>

<body>

<div class="card large-card">

    <h1>Сохранённые заявки</h1>

    <p class="author">
        Проект выполнила: Рыбалко Евгения
    </p>

    <?php if (empty($applications)): ?>

        <div class="empty-box">

            Пока нет сохранённых заявок

        </div>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                <tr>

                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Дата рождения</th>
                    <th>Пол</th>
                    <th>Биография</th>
                    <th>Контракт</th>
                    <th>Языки</th>
                    <th>Дата создания</th>

                </tr>

                </thead>

                <tbody>

                <?php foreach ($applications as $app): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($app['id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($app['full_name']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($app['phone']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($app['email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($app['birth_date']) ?>
                        </td>

                        <td>
                            <?= $app['gender'] === 'male'
                                ? 'Мужской'
                                : 'Женский' ?>
                        </td>

                        <td class="bio-cell">
                            <?= nl2br(
                                htmlspecialchars(
                                    $app['biography']
                                )
                            ) ?>
                        </td>

                        <td>
                            <?= $app['agreement']
                                ? 'Да'
                                : 'Нет' ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $app['languages']
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $app['created_at']
                            ) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

    <div class="bottom-link">

        <a href="index.php">

            Вернуться к форме

        </a>

    </div>

</div>

</body>

</html>