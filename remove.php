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

$deleteQuery = $connection->prepare("DELETE FROM books WHERE id = ?");
$deleteQuery->execute([$_GET['id']]);

header("Location: /");