<?php
  require_once "pdo.php";
  session_start();

  if (isset($_POST['email'],$_POST['password']))
  {
    // Data validation
    if ( strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1)
    {
        $_SESSION['error'] = 'Все поля должны быть заполнены';
        header("Location: login.php");
        return;
    }
    if ( strpos($_POST['email'],'@') === false )
    {
        $_SESSION['error'] = 'Неправильный email';
        header("Location: login.php");
        return;
    }
    $sql = "SELECT * FROM users WHERE email =:email AND pass=:password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':email' => $_POST['email'],
        ':password' => $_POST['password']));

    $row =$stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $_SESSION['success'] = 'Вход успешен';
        $_SESSION['name'] = htmlentities($row['user_id']);
        header( 'Location: index.php' ) ;
    }
    else
    {
      $_SESSION['error'] = 'Неверная связка почты и пароля';
      header("Location: login.php");
      return;
    }
    return;
  }
?>
<p>Вход</p>
<?php
if ( isset($_SESSION['error']) )
{
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

<form method="post">
<p>Почта:
<input type="text" name="email"></p>
<p>Пароль:
<input type="password" name="password"></p>
<p><input type="submit" value="Войти"/>
<a href="index.php">Отмена</a></p>
</form>
