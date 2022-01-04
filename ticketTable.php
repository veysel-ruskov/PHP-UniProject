<?php
	require_once('DbHelper.php');
?>
<html>
<head>
</head>
<body>
	<?php
		$conn = DbHelper::GetConnection();
		$stm = $conn->query("SELECT * FROM ticket");
		$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
		unset($conn);
	?>
	<table>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Content</th>
            <th>Visible</th>
            <th>For who</th>
            <th><a href="ticket.php">Добави</a></th>

		</tr>
		<?php
			foreach($rows as $r) {
			?>
			
				<tr>
					
					<td><?=$r["ID"]?></td>
					<td><?= $r["Title"]?></td>
					<td><?= $r["Content"]?></td>
                    <td><?= $r["Visible"]?></td>
                    <td><?= $r["ForWho"]?></td>
					<td>
						<a href="ticket.php?id=<?=$r["ID"]?>">Edit</a>
						<a href="deleteTicket.php?id=<?=$r["ID"]?>">Delete</a>
					</td>
				</tr>
			<?php
			}
		?>
	</table>
</body>
</html>