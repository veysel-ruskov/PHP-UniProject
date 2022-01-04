<?php
	require_once('DbHelper.php');
?>
<html>
<head>
</head>
<body>
	<?php
		$conn = DbHelper::GetConnection();
		$stm = $conn->query("SELECT * FROM users");
		$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
		unset($conn);
	?>
	<table>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Password</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Position</th>
		</tr>
		<?php
			foreach($rows as $r) {
			?>
			
				<tr>
					
					<td><?=$r["ID"]?></td>
					<td><?= $r["Username"]?></td>
					<td><?= $r["Password"]?></td>
					<td><?= $r["FirstName"]?></td>
					<td><?=$r["LastName"]?></td>
					<td><?=$r["Position"]?></td>
					<td>
						<a href="ticket.php?id=<?=$r["ID"]?>">Tickets</a>
						<a href="delete.php?id=<?=$r["ID"]?>">Delete</a>
					</td>
				</tr>
			<?php
			}
		?>
	</table>
</body>
</html>