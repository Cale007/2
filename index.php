<?php
	// Autoloader
	function uploadClass($class) : void
	{
		require("classes/$class.php");
	}
	spl_autoload_register("uploadClass");

	Database::connect('localhost', 'root', '', 'discussion_db');

	$discussion = new Discussion();

	// Zpracování odeslaného formuláře
	if ($_POST)
	{
		$discussion->addMessage($_POST['nickname'], $_POST['message']);
		header('Location: index.php'); // Přesměrování
	}
?>

<!DOCTYPE html>

<html lang="cs-cz">
<head>
	<meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
	<title>Discussion</title>
</head>
<body>

	<div class="discussion">

		<?php
			$discussion->list();
		?>

		<form method="post">
			Přezdívka<br />
			<input name="nickname" type="text" /><br />
			Zpráva<br />
			<textarea name="message" class="area"></textarea><br />
			<div class="submit">
				<input type="submit" value="send" />
			</div>
		</form>

	</div>

<body>
</html>