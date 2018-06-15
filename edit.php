<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['autos_id'],$_POST['model'], $_POST['maker'],
            $_POST['milage'],$_POST['year']) ) {

  $sql = "UPDATE autos SET model = :model,
          make = :maker, year = :year,
          mileage=:milage
          WHERE autos_id = :autos_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':autos_id' => $_POST['autos_id'],
                          ':model' => $_POST['model'],
                          ':maker' => $_POST['maker'],
                          ':milage' => $_POST['milage'],
                          ':year' => $_POST['year']
                                              ));
    $_SESSION['success'] = 'Запись отредактированна';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Нет нужного авто";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT autos_id,model,make,mileage,year FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Неверный идентификатор авто';
    header( 'Location: index.php' ) ;
    return;
}
$model=$row['model'];
$maker=$row['make'];
$mileage=$row['mileage'];
$year=$row['year'];
?>

<p>Редактировать запись</p>
<form method="post">
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<p>Название:
<input type="text" name="model" value="<?= $row['model'] ?>"></p>
<p>Марка:
<input type="text" name="maker" value="<?= $row['make'] ?>"></p>
<p>Год производства:
<input type="text" name="year" value="<?= $row['year'] ?>"></p>
<p>Пробег:
<input type="text" name="milage" value="<?= $row['mileage'] ?>"></p>
<p><input type="submit" value="Редактировать"/>
<a href="index.php">Отмена</a></p>
</form>
