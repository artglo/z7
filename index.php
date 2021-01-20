<?php
function login($nick,$haslo)
{
    $connect = new mysqli('aglowinski.com.pl','00315510_zadanie7','1236547!','00315510_zadanie7');
    mysqli_set_charset($connect, "utf8");
    $yourQuery = $connect -> query("SELECT * FROM users WHERE nick LIKE '$nick'");
    $person = $yourQuery -> fetch_assoc();
    if($_COOKIE['blokada'] != 1){
        if($person['nick'] == $nick && $person['haslo'] == $haslo){
            $idu = $person['idu'];
            setcookie('idu',"$idu");
            setcookie('nick',"$nick");
            echo "<script>window.location = './panel.php'</script>";
        }
        else {
            $idu = $person['idu'];
            $Query = $connect -> query("SELECT * FROM logi WHERE idu LIKE $idu");
            if($Query -> num_rows != 0){
                $logs = $Query -> fetch_assoc();
                $next_fail = $logs['bledy_logowania'] - 1;
                if($next_fail == 0){
                    setcookie('blokada', 1 ,time()+120);
                    // $connect -> query("DELETE FROM `logi` WHERE idu LIKE $idu");
                    $connect -> query("UPDATE `logi` SET `bledy_logowania`=2 WHERE idu LIKE $idu");
                    echo "Twoje konto zostało zablokowane na 2 minuty";
                }
                else{
                    echo "Zły nick lub hasło. Pozostały $next_fail próby logowania";
                    $connect -> query("UPDATE `logi` SET `bledy_logowania`=$next_fail WHERE idu LIKE $idu");
                }

            }
            else{
                echo "Zły nick lub hasło. Pozostały 2 próby logowania";
                $connect -> query("INSERT INTO `logi`(`idl`, `idu`, `bledy_logowania`)
                VALUES (NULL,$idu,2)");
            }
        }
    }
    else{
        echo "Twoje konto próby logowania zostały zablokowane na 2 minuty po 3 nieudanych próbach logowania";
    }
}
if(isset($_POST['zaloguj'])){
    $login = $_POST['login'];
    $pass1 = $_POST['pass1'];
    login($login,$pass1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artur Głowiński</title>
</head>
<body>
<h3>Logowanie:</h3>
<form action="" method="post">
        Login: <br><input type="text" required minlength="5" maxlength="15" name="login"><br><br>
        Hasło: <br><input type="password" required minlength="5" maxlength="15" name="pass1"><br><br>
        <input type="submit" name="zaloguj" value="Zaloguj">
    </form><br>
    <a href="./rejestracja.php">Nie masz konta, zarejestruj się</a>
</body>
</html>
