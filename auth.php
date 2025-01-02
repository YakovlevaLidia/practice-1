<?

require_once("settings.php");

if (isset($_COOKIE['AUTH'])) {
	header("Location: /");
	exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
	$hasError = false;
	$errorMessage = "";
	
	if ($_POST['username'] != $globalSettings["admin"]["username"] || $_POST['password'] != $globalSettings["admin"]["password"]) {
		$hasError = true;
		$errorMessage = "<b>Ошибка!</b> Указаны неверные данные для входа";
	}
	
	if ($hasError) {
		header("Location: /auth.php?error=" . $errorMessage);
	} else {
		setcookie('AUTH', 1);
		header("Location: /");
	}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
  	<?
		if (isset($_GET['error'])) {
	?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  <?=$_GET['error']?>
	</div>
	<? } ?>
<form action="/auth.php" method="POST">
  <div class="form-group">
    <label for="username">Имя пользователя</label>
    <input class="form-control" id="username" name="username" aria-describedby="username" placeholder="Укажите имя пользователя">
    <small id="username" class="form-text text-muted">Для входа в систему используйте учетные данные предоствлаенные отделом ЦИТ</small>
  </div>
  <div class="form-group">
    <label for="password">Пароль</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
  </div>
  <button type="submit" class="btn btn-primary">Авторизоваться</button>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
