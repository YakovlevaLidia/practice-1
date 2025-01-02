<?

require_once("dbconnection.php");

if (!isset($_GET['id'])) {
	echo "<b>Ошибка!</b> Не указан ID книги";
	die(404);
}

$booksList = $connection->prepare("SELECT * FROM books WHERE id = ?");
$booksList->execute([$_GET['id']]);
$bookData = $booksList->fetchAll();

if (count($bookData) <= 0) {
	echo "<b>Ошибка!</b> Книга с таким ID не найдена!";
	die(404);
}

$book = $bookData[0];

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Предмет #<?=$book['id']?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
  <main class="col-4 col-md-9 col-xl-8 py-md-3 pl-md-5" role="main">
	<div>
		<form action="/save.php" method="POST">
		  <div class="form-group">
			<label for="id">ID Предмета</label>
			<input class="form-control" name="id" id="id" value="<?=$book['id']?>" readonly>
		  </div>
		  <div class="form-group">
			<label for="name">Название предмета</label>
			<input class="form-control" name="name" id="name" value="<?=$book['name']?>" placeholder="Полное наименование">
		  </div>
		  <div class="form-group">
			<label for="type">Тип предмета</label>
			<select class="form-control" name="type" id="type">
			  <option value="0" <? if (intVal($book['type']) == 0) echo "selected"; ?>>Книга</option>
			  <option value="1" <? if (intVal($book['type']) == 1) echo "selected"; ?>>Журнал</option>
			</select>
		  </div>
		  <div class="form-group">
			<label for="price">Цена</label>
			<input class="form-control" name="price" id="price" value="<?=$book['price']?>" placeholder="Стоимость в рублях">
		  </div>
		  <div class="form-group">
			<label for="amount">Доступное количество</label>
			<input class="form-control" name="amount" id="amount" value="<?=$book['amount']?>" placeholder="Количество доступных книг">
		  </div>
		  <button type="submit" class="btn btn-success">Сохранить данные</button>
		</form>
	</div>
	</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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