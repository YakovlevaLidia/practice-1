<?

require_once("dbconnection.php");

if (!isset($_POST['id'])) {
	echo "<b>Ошибка!</b> Не указан ID книги";
	die(404);
}

$booksList = $connection->prepare("SELECT * FROM books WHERE id = ?");
$booksList->execute([$_POST['id']]);
$bookData = $booksList->fetchAll();

if (count($bookData) <= 0) {
	echo "<b>Ошибка!</b> Книга с таким ID не найдена!";
	die(404);
}

$query = $connection->prepare("UPDATE books SET name = ?, type = ?, price = ?, amount = ? WHERE id = ?");
$query->execute([
	$_POST['name'],
	intVal($_POST['type']),
	floatVal($_POST['price']),
	intVal($_POST['amount']),
	intVal($_POST['id'])
]);

header("Location: /");