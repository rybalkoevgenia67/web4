<!DOCTYPE html>
<html lang="ru">

<head>

<meta charset="UTF-8">

<title>Лабораторная №4</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="card">

<h1>Анкета пользователя</h1>

<p class="author">
Проект выполнила: Рыбалко Евгения
</p>

<form action="submit.php" method="POST">

<label>ФИО</label>

<input
type="text"
name="full_name"
value="<?= htmlspecialchars($values['full_name']) ?>"
class="<?= isset($errors['full_name']) ? 'error' : '' ?>"
>

<?php if(isset($errors['full_name'])): ?>
<p class="message"><?= $errors['full_name'] ?></p>
<?php endif; ?>

<label>Телефон</label>

<input
type="tel"
name="phone"
value="<?= htmlspecialchars($values['phone']) ?>"
class="<?= isset($errors['phone']) ? 'error' : '' ?>"
>

<?php if(isset($errors['phone'])): ?>
<p class="message"><?= $errors['phone'] ?></p>
<?php endif; ?>

<label>Email</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($values['email']) ?>"
class="<?= isset($errors['email']) ? 'error' : '' ?>"
>

<label>Дата рождения</label>

<input
type="date"
name="birth_date"
value="<?= htmlspecialchars($values['birth_date']) ?>"
>

<label>Пол</label>

<div class="radio-group">

<label>
<input type="radio"
name="gender"
value="male">
Мужской
</label>

<label>
<input type="radio"
name="gender"
value="female">
Женский
</label>

</div>

<label>Любимые языки</label>

<select
name="languages[]"
multiple
class="<?= isset($errors['languages']) ? 'error' : '' ?>"
>

<?php

$userLanguages = json_decode(
    $_COOKIE['languages'] ?? '[]',
    true
);

foreach ($languages as $language):

?>

<option
value="<?= $language['id'] ?>"
<?= in_array($language['id'], $userLanguages ?? []) ? 'selected' : '' ?>
>

<?= htmlspecialchars($language['title']) ?>

</option>

<?php endforeach; ?>

</select>

<label>Биография</label>

<textarea
name="biography"
rows="5"
><?= htmlspecialchars($values['biography']) ?></textarea>

<label class="checkbox">

<input
type="checkbox"
name="agreement"
<?= !empty($values['agreement']) ? 'checked' : '' ?>
>

С контрактом ознакомлен(а)

</label>

<button type="submit">

Сохранить

</button>

</form>

</div>

</body>

</html>