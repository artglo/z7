<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artur Głowiński</title>
</head>
<body>
    <h3>Rejestracja:</h3>
    <form action="" method="post">
        Login: <br><input type="text" required minlength="5" maxlength="15" name="login"><br><br>
        Hasło: <br><input type="password" required minlength="5" maxlength="15" name="pass1"><br><br>
        Potwierdzenie hasła: <br><input type="password" required minlength="5" maxlength="15" name="pass2"><br><br>
        <input type="submit" name="rejestruj" value="Zarajestruj">
    </form>
<?php
function addToDataBase($nick,$haslo){
    $connect = new mysqli('aglowinski.com.pl','00315510_zadanie7','1236547!','00315510_zadanie7');
    mysqli_set_charset($connect, "utf8");
    mysqli_query($connect, "INSERT INTO `users`(`idu`, `nick`, `haslo`)
    VALUES (NULL,'$nick','$haslo')");
    mkdir($nick);
}
if(isset($_POST['rejestruj'])){
    $login = $_POST['login'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if($pass1 == $pass2){
        addToDataBase($login,$pass1);
        echo "<script>window.location = './index.php'</script>";
    }else{
        echo "Hasła do siebie nie pasują";
    }
}
?>
</body>
</html>
