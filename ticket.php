<?php
require_once('DbHelper.php');
$conn = DbHelper::GetConnection();
$id = -1;
$ticket = null;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$stm = $conn->prepare("SELECT * FROM ticket WHERE id = ?");
	$stm->execute(array($id));
	$ticket = $stm->fetchAll(PDO::FETCH_ASSOC);
	if (count($ticket)) {
		$ticket = $ticket[0];
	}
}
?>
<html>
<link rel="stylesheet" href="style.css">

<head>
</head>

<body>
	<?php
    if (isset($_POST['btnTicket'])) {
        if (isset($_POST['title']) && $_POST['title'] != '') {
            if ($GLOBALS['ticket'] != null) {
                    $stm = $GLOBALS['conn']->prepare('UPDATE ticket SET Title=?, Content=?, Visible=?, ForWho=? WHERE id=?');
                    $stm->execute(array($_POST['title'], $_POST['content'], $_POST['visible'], $_POST['forwho'], $GLOBALS['id']));
                } else {
                    $stm = $GLOBALS['conn']->prepare('INSERT INTO ticket(Title, Content, Visible, ForWho) VALUES(?, ?, ?, ?)');
                    $stm->execute(array($_POST['title'], $_POST['content'], $_POST['visible'], $_POST['forwho']));
                }
            header('Location: ticketTable.php');        
        } else {
            $GLOBALS["error"] = "Заглавието е задължително";
        }
    }
	?>
	<form method="post">
		<p>
        <label for="title">Заглавие</label>
        <input type="text" id="title" name="title" value="<?= ($ticket != null) ? $ticket["Title"] : "" ?>"  />
		</p>
        <p>
        <label for="content">Съдържание</label>
        <input type="text" id="content" name="content" value="<?= ($ticket != null) ? $ticket["Content"] : "" ?>"  />
		</p>
        <label for="visible">Видимо за:</label>
            <select type="text" id="visible" name="visible">
        <option value="for me">за мен</option>
        <option value="for all">за всички</option>
        </select>
        <p></p>
        <label for="forwho">За кого се отнася:</label>
            <select type="text" id="forwho" name="forwho">
        <option value="office sup">офис поддръжка</option>
        <option value="office texn sup">техническа поддръжка</option>
        </select>
        <p>
            <button type="submit" name="btnTicket"> <?= ($ticket != null) ? 'Упрегдни' : 'Добави' ?></button>
        </p>
	</form>
</body>

</html>