<?

require_once("dbconnection.php");

if (isset($_POST['method']) && $_POST['method'] == "NEW") {
	$data = array(
		"name" => null,
		"type" => -1,
		"price" => 0,
		"amount" => 0
	);
	
	$hasError = false;
	$errorMessage = "";
	
	if (isset($_POST['type']) || intVal($_POST['type']) == 1 || intVal($_POST['type']) == 0) {
		$data['type'] = $_POST['type'];
	} else {
		$hasError = true;
		$errorMessage = "<b>Ошибка!</b> Указан неверный тип предмета!";
	}
	
	if (isset($_POST['name']) && strlen($_POST['name']) > 0) {
		$data['name'] = $_POST['name'];
	} else {
		$hasError = true;
		$errorMessage = "<b>Ошибка!</b> Не указано название предмета!";
	}
	
	if (isset($_POST['amount']) && intVal($_POST['amount']) >= 0) {
		$data['amount'] = intVal($_POST['amount']);
	} else {
		$hasError = true;
		$errorMessage = "<b>Ошибка!</b> Неверно указано количество предметов!";
	}
	
	if (isset($_POST['price']) && floatVal($_POST['price']) >= 0) {
		$data['price'] = floatVal($_POST['price']);
	} else {
		$hasError = true;
		$errorMessage = "<b>Ошибка!</b> Неверно указана цена предмета!";
	}
	
	if ($hasError) {
		header("Location: /add.php?error=" . $errorMessage);
	} else {
		$createQuery = $connection->prepare("INSERT INTO books (name, type, price, amount) VALUES (?, ?, ?, ?)");
		$createQuery->execute([
			$data['name'],
			$data['type'],
			$data['price'],
			$data['amount']
		]);
		
		header("Location: /");
	}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Добавление нового предмета</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
  <main class="col-4 col-md-9 col-xl-8 py-md-3 pl-md-5" role="main">
	<?
		if (isset($_GET['error'])) {
	?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  <?=$_GET['error']?>
	</div>
	<? } ?>
	<div>
		<form action="/add.php" method="POST">
		  <input name="method" value="NEW" hidden>
		  <div class="form-group">
			<label for="name">Название предмета</label>
			<input class="form-control" name="name" id="name" placeholder="Полное наименование">
		  </div>
		  <div class="form-group">
			<label for="type">Тип предмета</label>
			<select class="form-control" name="type" id="type">
			  <option value="0">Книга</option>
			  <option value="1">Журнал</option>
			</select>
		  </div>
		  <div class="form-group">
			<label for="price">Цена</label>
			<input class="form-control" name="price" id="price" placeholder="Стоимость в рублях">
		  </div>
		  <div class="form-group">
			<label for="amount">Доступное количество</label>
			<input class="form-control" name="amount" id="amount" placeholder="Количество доступных книг">
		  </div>
		  <button type="submit" class="btn btn-success">Добавить предмет</button>
		</form>
	</div>
	</main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
		  $('#price').mask('###0,00', {reverse: true});
		  $('#amount').mask('00000');
		});
	</script>
  </body>
</html>