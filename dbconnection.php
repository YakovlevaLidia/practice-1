<?

if (!isset($_COOKIES['AUTH'])) {
	header("Location: /auth.php");
	exit();
}

require_once("settings.php");

$connection = new PDO("mysql:host=" . $globalSettings["database"]["hostname"] . ";port=" . $globalSettings["database"]["port"] . ";dbname=" . $globalSettings["database"]["basename"], 
	$globalSettings["database"]["username"], $globalSettings["database"]["password"]);

$types = array(
	0 => "Книга",
	1 => "Журнал"
);

$actions = array(
	"ADD" => function(int $id) use ($connection) {
		$addQuery = $connection->prepare("UPDATE books SET amount = amount + 1 WHERE id = ?");
		$addQuery->execute([$id]);
	},
	"REMOVE" => function(int $id) use ($connection) {
		$removeQuery = $connection->prepare("UPDATE books SET amount = amount - 1 WHERE id = ?");
		$removeQuery->execute([$id]);
	}
);

$checkTableQuery = $connection->prepare("SHOW TABLES LIKE 'books'");
$checkTableQuery->execute([]);
$tableData = $checkTableQuery->fetchAll();

if (count($tableData) != 1) {
	echo "<b>Ошибка!</b> Не создана база данных/таблица в ней. Импортируйте файл dump.sql в корне сайта<br>Затем используйте файл settings.php для настройки доступа к базе данных.";
	die(500);
}