<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Лабораторная работа №4</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="card">

    <h1>Анкета пользователя</h1>

    <p class="author">
        Проект выполнила: Рыбалко Евгения
    </p>

    <?php if (!empty($successMessage)): ?>

        <div class="success-message">

            <?= htmlspecialchars($successMessage) ?>

        </div>

    <?php endif; ?>

    <form
        action="submit.php"
        method="POST"
    >

        <!-- ФИО -->

        <label for="full_name">

            ФИО

        </label>

        <input
            type="text"
            id="full_name"
            name="full_name"

            value="<?= htmlspecialchars($values['full_name']) ?>"

            class="<?= isset($errors['full_name']) ? 'error' : '' ?>"
        >

        <?php if (isset($errors['full_name'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['full_name']) ?>

            </div>

        <?php endif; ?>

        <!-- Телефон -->

        <label for="phone">

            Телефон

        </label>

        <input
            type="tel"
            id="phone"
            name="phone"

            value="<?= htmlspecialchars($values['phone']) ?>"

            class="<?= isset($errors['phone']) ? 'error' : '' ?>"
        >

        <?php if (isset($errors['phone'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['phone']) ?>

            </div>

        <?php endif; ?>

        <!-- EMAIL -->

        <label for="email">

            Email

        </label>

        <input
            type="email"
            id="email"
            name="email"

            value="<?= htmlspecialchars($values['email']) ?>"

            class="<?= isset($errors['email']) ? 'error' : '' ?>"
        >

        <?php if (isset($errors['email'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['email']) ?>

            </div>

        <?php endif; ?>

        <!-- ДАТА -->

        <label for="birth_date">

            Дата рождения

        </label>

        <input
            type="date"
            id="birth_date"
            name="birth_date"

            value="<?= htmlspecialchars($values['birth_date']) ?>"

            class="<?= isset($errors['birth_date']) ? 'error' : '' ?>"
        >

        <?php if (isset($errors['birth_date'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['birth_date']) ?>

            </div>

        <?php endif; ?>

        <!-- ПОЛ -->

        <label>

            Пол

        </label>

        <div class="radio-group">

            <label>

                <input
                    type="radio"
                    name="gender"
                    value="male"

                    <?= $values['gender'] === 'male'
                        ? 'checked'
                        : '' ?>
                >

                Мужской

            </label>

            <label>

                <input
                    type="radio"
                    name="gender"
                    value="female"

                    <?= $values['gender'] === 'female'
                        ? 'checked'
                        : '' ?>
                >

                Женский

            </label>

        </div>

        <?php if (isset($errors['gender'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['gender']) ?>

            </div>

        <?php endif; ?>

        <!-- ЯЗЫКИ -->

        <label for="languages">

            Любимые языки программирования

        </label>

        <?php

        $selectedLanguages =
            json_decode(
                $_COOKIE['languages'] ?? '[]',
                true
            );

        ?>

        <select
            id="languages"
            name="languages[]"
            multiple

            class="<?= isset($errors['languages']) ? 'error' : '' ?>"
        >

            <?php foreach ($languages as $language): ?>

                <option

                    value="<?= $language['id'] ?>"

                    <?= in_array(
                        $language['id'],
                        $selectedLanguages ?? []
                    )
                        ? 'selected'
                        : '' ?>
                >

                    <?= htmlspecialchars(
                        $language['title']
                    ) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($errors['languages'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['languages']) ?>

            </div>

        <?php endif; ?>

        <!-- БИОГРАФИЯ -->

        <label for="biography">

            Биография

        </label>

        <textarea
            id="biography"
            name="biography"
            rows="5"

            class="<?= isset($errors['biography']) ? 'error' : '' ?>"
        ><?= htmlspecialchars($values['biography']) ?></textarea>

        <?php if (isset($errors['biography'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['biography']) ?>

            </div>

        <?php endif; ?>

        <!-- СОГЛАСИЕ -->

        <div class="checkbox">

            <label>

                <input
                    type="checkbox"
                    name="agreement"

                    <?= !empty($values['agreement'])
                        ? 'checked'
                        : '' ?>
                >

                С контрактом ознакомлен(а)

            </label>

        </div>

        <?php if (isset($errors['agreement'])): ?>

            <div class="message">

                <?= htmlspecialchars($errors['agreement']) ?>

            </div>

        <?php endif; ?>

        <!-- КНОПКА -->

        <button type="submit">

            Сохранить

        </button>

    </form>

    <!-- ССЫЛКИ -->

    <div class="bottom-link">

        <a href="view.php">

            Просмотреть заявки

        </a>

    </div>

</div>

</body>

</html>