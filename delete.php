<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['autos_id']));
    $_SESSION['success'] = 'Запись удалена';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Нет нужного авто";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT autos_id,model,make FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Неверный идентификатор авто';
    header( 'Location: index.php' ) ;
    return;
}

?>
<p>Подтвердить удаление <?= htmlentities($row['make']).' '.htmlentities($row['model']) ?></p>

<form method="post">
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<input type="submit" value="Удалить" name="delete">
<a href="index.php">Отмена</a>
</form>
