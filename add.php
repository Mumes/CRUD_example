<?php
  require_once "pdo.php";
  session_start();
  if(!isset($_SESSION[$email],$_SESSION[$pass]))
    die("Доступ запрещен. Войдите в систему под своим пользователем");

 ?>


 <p>Add A New User</p>
 <form method="post">
 <p>Name:
 <input type="text" name="name"></p>
 <p>Email:
 <input type="text" name="email"></p>
 <p>Password:
 <input type="password" name="password"></p>
 <p><input type="submit" value="Add New"/>
 <a href="index.php">Cancel</a></p>
 </form>
