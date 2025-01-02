<?

require_once("dbconnection.php");

$booksList = $connection->prepare("SELECT * FROM books WHERE amount > 0");
$booksList->execute([]);
$availableData = $booksList->fetchAll();

$unavailableList = $connection->prepare("SELECT * FROM books WHERE amount <= 0");
$unavailableList->execute([]);
$unavailableData = $unavailableList->fetchAll();

if (isset($_GET['action']) && isset($_GET['id'])) {
	$action = $_GET['action'];
	$id = $_GET['id'];
	
	$actions[$action]($id);
	
	header("Location: /");
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Система управления библиотекой</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
	<div>
		<h2>Доступные книги/журналы <a href="/add.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Добавить новый предмет"><i class="bi bi-plus" style="color: green;"></i></a></h2>
		<br>
		<table class="table">
		  <thead class="thead-light">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Название</th>
			  <th scope="col">Тип предмета</th>
			  <th scope="col">Цена</th>
			  <th scope="col">Доступное кол-во</th>
			  <th scope="col">Действие</th>
			</tr>
		  </thead>
		  <tbody>
		  <?
		  
			foreach ($availableData as $node) {
		  ?>
			<tr>
			  <th scope="row"><?=$node['id']?></th>
			  <td><?=$node['name']?></td>
			  <td><?=$types[$node['type']]?></td>
			  <td><?
				$value = floatVal($node['price']);
			  
				if ($value <= 0.0) {
					echo "-";
				} else {
					echo $value . " ₽";
				}
			  ?></td>
			  <td><?=$node['amount']?></td>
			  <td>
				<a href="/index.php?action=ADD&id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Добавить +1 к количеству"><i class="bi bi-plus" style="color: green;"></i></a>
				<a href="/index.php?action=REMOVE&id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Отнять -1 от количества"><i class="bi bi-dash" style="color: red;"></i></a>
				<a href="/edit.php?id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Изменить предмет"><i class="bi bi-pencil" style="color: black;"></i></a>
				<a href="/remove.php?id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Удалить предмет"><i class="bi bi-x-lg" style="color: red;"></i></a>
			  </td>
			</tr>
			<? } ?>
		  </tbody>
		</table>
	</div>
	<? if (count($unavailableData) > 0) { ?>
	<div>
		<h2>Недоступные книги/журналы</h2>
		<p>Предметы, количество которых равно нулю</p>
		<br>
		<table class="table">
		  <thead class="thead-light">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Название</th>
			  <th scope="col">Тип предмета</th>
			  <th scope="col">Цена</th>
			  <th scope="col">Доступное кол-во</th>
			  <th scope="col">Действие</th>
			</tr>
		  </thead>
		  <tbody>
		  <? foreach ($unavailableData as $node) { ?>
				<tr>
				  <th scope="row"><?=$node['id']?></th>
				  <td><?=$node['name']?></td>
				  <td><?=$types[$node['type']]?></td>
				  <td><?
					$value = floatVal($node['price']);
				  
					if ($value <= 0.0) {
						echo "-";
					} else {
						echo $value . " ₽";
					}
				  ?></td>
				  <td><?=$node['amount']?></td>
				  <td>
					<a href="/index.php?action=ADD&id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Добавить +1 к количеству"><i class="bi bi-plus" style="color: green;"></i></a>
					<a href="/edit.php?id=<?=$node['id']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Изменить предмет"><i class="bi bi-pencil" style="color: black;"></i></a>
				  </td>
				</tr>
			<? } ?>
		  </tbody>
		</table>
	</div>
	<? } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		  return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	</script>
  </body>
</html>