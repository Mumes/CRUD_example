<?php
  require_once "pdo.php";
  session_start();
  if(!isset($_SESSION['name']))
    die("Доступ запрещен. Войдите в систему под своим пользователем");


    if (isset($_POST['model'],$_POST['maker'],$_POST['year'],$_POST['milage']))
    {
      // Data validation
      if ( strlen($_POST['model']) < 1 || strlen($_POST['maker']) < 1||
              strlen($_POST['year']) < 1 || strlen($_POST['milage']) < 1)
      {
          $_SESSION['error'] = 'Все поля должны быть заполнены';
          header("Location: add.php");
          return;
      }
    /*  if ( is_numeric($_POST['year'])||
              is_numeric($_POST['milage']) === false )
      {
          $_SESSION['error'] = 'Год и пробег должны быть числами';
          header("Location: add.php");
          return;
      }*/

    $sql = "INSERT INTO autos (make, model, year, mileage,user_id)
      VALUES (:maker, :model, :year, :milage, :user_id);";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':maker' => $_POST['maker'],
          ':model' => $_POST['model'],
          ':year' => $_POST['year'],
          ':milage' => $_POST['milage'],
          ':user_id' => $_SESSION['name'],
        ));

    header("Location: index.php");

      return;
    }
 ?>


 <p>Добавить автомобиль</p>
 <?php
  echo '<p style="color:red">'.$_SESSION['name']."</p>\n";
 if ( isset($_SESSION['error']) )
 {
     echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
     unset($_SESSION['error']);
 }
 ?>
 <form method="post">
 <p>Название:
 <input type="text" name="model"></p>
 <p>Марка:
 <input type="text" name="maker"></p>
 <p>Год производства:
 <input type="text" name="year"></p>
 <p>Пробег:
 <input type="text" name="milage"></p>
 <p><input type="submit" value="Добавить"/>
 <a href="index.php">Отмена</a></p>
 </form>
