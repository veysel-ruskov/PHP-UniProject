<?php
require_once('DbHelper.php');
$conn = DbHelper::GetConnection();
$id = -1;
$user = null;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$stm = $conn->prepare("SELECT * FROM users WHERE id = ?");
	$stm->execute(array($id));
	$users = $stm->fetchAll(PDO::FETCH_ASSOC);
	if (count($users)) {
		$user = $users[0];
	}
}
?>
<html>
<link rel="stylesheet" href="style.css">

<head>
</head>

<body>
	<?php
	$errors = array();
	if (isset($_POST['btnRegister'])) {
		if (!isset($_POST['tbUsername']) || mb_strlen($_POST['tbUsername'], 'utf-8') < 4 || mb_strlen($_POST['tbUsername'], 'utf-8') > 50) {
			$errors[] = "Потребителкото име е задължително!";
		}
		if (!isset($_POST['tbPassword']) || mb_strlen($_POST['tbPassword'], 'utf-8') < 6 || mb_strlen($_POST['tbPassword'], 'utf-8') > 50 || !isset($_POST['tbPasswordAgain']) || $_POST['tbPasswordAgain'] != $_POST['tbPassword']) {
			$errors[] = "Паролата е задължителна!";
		}
        if (!isset($_POST['tbFirstName']) || mb_strlen($_POST['tbFirstName'], 'utf-8') < 2 || mb_strlen($_POST['tbFirstName'], 'utf-8') > 100) {
			$errors[] = "Името е задължително!";
		}
        if (!isset($_POST['tbLastName']) || mb_strlen($_POST['tbLastName'], 'utf-8') < 2 || mb_strlen($_POST['tbLastName'], 'utf-8') > 100) {
			$errors[] = "Фамилията е задължителна!";
		}
		if (count($errors) == 0) {
			if ($user == null) {
				$stm = $conn->prepare('INSERT INTO users(Username, Password, FirstName, LastName, Position) VALUES(?, ?, ?, ?, ?)');
				$stm->execute(array($_POST['tbUsername'], $_POST['tbPassword'],$_POST['tbFirstName'],$_POST['tbLastName'], $_POST['tbPosition'],));
			} else {
				$stm = $conn->prepare('UPDATE users SET Username = ?, Password = ?, firstname = ?, lastname = ?, position = ?, WHERE id = ?');
				$stm->execute(array($_POST['tbUsername'], $_POST['tbPassword'], $_POST['tbFisrtName'], $_POST['tbLastName'], $_POST['tbPosition'], $id));
			}
		}
	}

	if (isset($_POST['btnLogging'])) {
		$valid = false;
		$stm = $conn->prepare("SELECT * FROM users WHERE username = ?");
		$stm->execute(array($_POST["lgUsername"]));
		$usersLog = $stm->fetchAll(PDO::FETCH_ASSOC);
	
		if(count($usersLog))
		{
		  foreach($usersLog as $u)
		  {
			if($u["Username"] == $_POST["lgUsername"] && $u["Password"] == $_POST["lgPassword"])
			{
				$valid = true;
			}
		  }
		}
		if (!isset($_POST['lgUsername'])) {
			$errors[] = "Въведенето потребителкото име е невалидно!";
		}
		if (!isset($_POST['lgPassword']) ) {
			$errors[] = "Въведената парола е невалидна!";
		}
		header("Location: ticketTable.php");
	}

	unset($conn);

	if (count($errors) > 0) {
	?>
		<ul style="color: red;">
			<?php
			foreach ($errors as $e) {
				echo "<li>$e</li>";
			}
			?>
		</ul>
	<?php
	}
	?>
	<form method="post">
		<p>
			<label for="tbUsername">Потребителско име:</label>
			<input type="text" id="tbUsername" name="tbUsername" value="<?= ($user != null) ? $user["username"] : "" ?>" />
		</p>
		<p>
			<label for="tbPassword">Парола:</label>
			<input type="password" id="tbPassword" name="tbPassword" />
		</p>
		<p>
			<label for="tbPasswordAgain">Парола(отново):</label>
			<input type="password" id="tbPasswordAgain" name="tbPasswordAgain" />
		</p>
        <p>
			<label for="tbFirstName">Име:</label>
			<input type="text" id="tbFirstName" name="tbFirstName" value="<?= ($user != null) ? $user["FirstName"] : "" ?>"  />
		</p>
        <p>
			<label for="tbLastName">Фамилия:</label>
			<input type="text" id="tbLastName" name="tbLastName" value="<?= ($user != null) ? $user["LastName"] : "" ?>" />
		</p>
		<label for="tbPosition">Позиция:</label>
            <select type="text" id="tbPosition" name="tbPosition">
        <option value="programmer - Junior">програмист - Junior</option>
        <option value="programmer - Mid-level">програмист - Mid-level</option>
        <option value="programmer - Senior">програмист - Senior</option>
        <option value="maintenance - office">поддръжка офис</option>
        <option value="maintenance - technical side">поддръжка - техническа част</option>
  </select>
        <p>
			<input type="submit" value="Регистриране" name="btnRegister" />
		</p>
	</form>

    <form method="post">
		<p>
			<label for="tbUsername">Потребителско име:</label>
			<input type="text" id="lgUsername" name="lgUsername"/>
		</p>
		<p>
			<label for="tbPassword">Парола:</label>
			<input type="password" id="lgPassword" name="lgPassword" />
        </p>    
        <p>
			<input type="submit" value="Влизане в акаунт" name="btnLogging" />
		</p>
	</form>
</body>

</html>