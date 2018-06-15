<?php
require_once "pdo.php";
session_start();

if (isset($_POST['email'],$_POST['password']))
{
  // Data validation
  if ( strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1)
  {
      $_SESSION['error'] = 'Все поля должны быть заполнены';
      header("Location: reg.php");
      return;
  }
  if ( strpos($_POST['email'],'@') === false )
  {
      $_SESSION['error'] = 'Неправильный email';
      header("Location: reg.php");
      return;
  }
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email = :email ");
  $stmt->execute(array(
      ':email' => $_POST['email']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo $row['email'].'\n';
  echo $_POST['email'];
  if ($row['email']==$_POST['email']) {
    $_SESSION['error'] = 'Данный пользователь уже существует';
    header("Location: reg.php");
    return;
  }

  $sql = "INSERT INTO users (email, pass)
            VALUES (:email, :password);";
  try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':email' => $_POST['email'],
        ':password' => $_POST['password']));
    $_SESSION['success'] = 'Регистрация успешна';
    header( 'Location: index.php' ) ;
    return;
  }
  catch(Exception $e)
  {
    $_SESSION['error'] = 'Не удалось зарегистрировать';
    header( 'Location: reg.php' ) ;
  }

}
?>
<h2>Регистрация</h2>
<?php
// Flash pattern
  if ( isset($_SESSION['error']) )
  {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) )
  {
      echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
      unset($_SESSION['success']);
  }?>
<form method="post">
<p>Почта:
<input type="text" name="email"></p>
<p>Пароль:
<input type="password" name="password"></p>
<p><input type="submit" value="Войти"/>
<a href="index.php">Cancel</a></p>
</form>
