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

<?php if (!empty($successMessage)): ?>
<div class="success">
<?= $successMessage ?>
</div>
<?php endif; ?>

<form action="submit.php" method="POST">

<label>ФИО</label>
<input
type="text"
name="full_name"
value="<?= htmlspecialchars($values['full_name']) ?>"
class="<?= isset($errors['full_name']) ? 'error' : '' ?>"
>

<label>Телефон</label>
<input
type="tel"
name="phone"
value="<?= htmlspecialchars($values['phone']) ?>"
class="<?= isset($errors['phone']) ? 'error' : '' ?>"
>

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
value="male"
<?= $values['gender'] === 'male' ? 'checked' : '' ?>>
Мужской
</label>

<label>
<input type="radio"
name="gender"
value="female"
<?= $values['gender'] === 'female' ? 'checked' : '' ?>>
Женский
</label>

</div>

<label>Языки программирования</label>

<?php
$selectedLanguages =
json_decode(
$_COOKIE['languages'] ?? '[]',
true
);
?>

<select
name="languages[]"
multiple
>

<?php foreach ($languages as $language): ?>

<option
value="<?= $language['id'] ?>"
<?= in_array($language['id'], $selectedLanguages ?? []) ? 'selected' : '' ?>
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

<div class="bottom-link">
<a href="view.php">
Просмотреть заявки
</a>
</div>

</div>

</body>
</html>