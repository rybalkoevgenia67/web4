<?php

require 'db.php';

$pdo = getDatabase();

$stmt = $pdo->query("
    SELECT
        a.*,
        GROUP_CONCAT(l.title SEPARATOR ', ') AS langs

    FROM applications a

    LEFT JOIN application_language al
        ON a.id = al.application_id

    LEFT JOIN languages l
        ON l.id = al.language_id

    GROUP BY a.id

    ORDER BY a.id DESC
");

$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Список заявок</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="wrapper">

    <div class="card">

        <h1>Сохранённые заявки</h1>

        <table>

            <tr>

                <th>ID</th>
                <th>ФИО</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Языки</th>

            </tr>

            <?php foreach ($applications as $item): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($item['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['full_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['phone']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['langs']) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        <div class="bottom-link">

            <a href="index.php">
                Назад к форме
            </a>

        </div>

    </div>

</div>

</body>

</html>