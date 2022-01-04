<?php
	require_once('DbHelper.php');
	$conn = DbHelper::GetConnection();
	$id = -1;
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	if(isset($_POST["btnYes"])) {
		$stm = $conn->prepare("DELETE FROM ticket WHERE id = ?");
		$stm->execute(array($id));
		header("Location: ticketTable.php");
	} else if(isset($_POST["btnNo"])) {
		header("Location: ticketTable.php");
	}
	unset($conn);
?>
<html>
	<head></head>
	<body>
		<form method="post">
			Избраният тикет ще бъде изтрит. Желаете ли да пордължите?
			<input type="submit" name="btnYes" value="да" />
			<input type="submit" name="btnNo" value="не" />
		</form>
	</body>
</html>