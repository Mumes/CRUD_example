<?php
  require_once "pdo.php";
  session_start();
 ?>

<html>
<head>
  <title>CRUD Максима</title>
</head>
<h2>Пример CRUD на основе базы данных автомобилей.</h2>
<?php
if ( isset($_SESSION['error']) )
{
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) )
{
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
if ( !isset($_SESSION['name']) )
{?>

   <p>Попытка <a href="add.php">зайти</a> без логина</p>
   <p>Пожалуйста, <a href="login.php">войдите</a> или <a href="reg.php">зарегистрируйтесь</a> </p>
<?php
}
else
{?>
   <p><a href="add.php">Добавить</a> автомобиль.</p>
   <p><a href="logout.php">Выйти</a> из сессии.</p>

<?php
}
?>
</html>
