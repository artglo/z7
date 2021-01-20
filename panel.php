<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artur Głowiński</title>
</head>
<body>
<html>
<form action="wyloguj.php">
    <button type="submit">Wyloguj</button>
</form><br>
<h1>Witaj <?php echo $_COOKIE['nick'] ?></h1><br>
<?php
    $connect = new mysqli('aglowinski.com.pl','00315510_zadanie7','1236547!','00315510_zadanie7');
    $idu = $_COOKIE['idu'];
    $Query = $connect -> query("SELECT * FROM logi WHERE idu LIKE $idu");
        if($Query -> num_rows != 0){
            $logs = $Query -> fetch_assoc();
            $data_error = $logs['datatime'];
            echo "<p style='color: red'>Ktoś próbował zalogować się na Twoje konto: $data_error</p>";
        }
        else {
            echo "Nie zarejestrowana nieudanych prób logowania na Twoje konto<br><br>";
        }
    function delLogs($idu){
        global $connect;
        $connect -> query("DELETE FROM `logi` WHERE idu LIKE $idu");
    }
    if(isset($_POST['delLogs'])){
        delLogs($idu);
    }
?>
<form action="" method="POST">
    <input type="submit" name="delLogs" value="Usuń logi">
</form>
<br>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">
    Wpisz nazwę folderu, do którego chcesz wysłać plik(jeśli folder główny, zostaw puste pole): <input type="text" name="folderName"/><br><br>
    <input type="file" name="plik"/>
    <input type="submit" value="Wyślij plik"/>
</form><br><br>
<h1>Stwórz nowy folder:</h1><br>
<form action="newfolder.php" method="post">
    Wpisz nazwę nowego foleru: <input type="text" required name="newfolder"><br>
    Dodaj folder: <input type="submit" name="addFolder">
</form>
<br><br>
<h1>Podkatalogi:</h1><br>
<?php
    $folder = $_COOKIE['nick'];
    if ($handle = @opendir("$folder")) {
        while ($file = @readdir($handle)) {
            if ($file != "." && $file != "..") {
                // $thelist .= "<li><a href='$folder/$file'>".$file."</a></li>";
                if($next_step = @opendir("$folder/$file")){
                    echo "$folder/$file";
                    echo "<ol>";
                    while($files = @readdir($next_step)){
                        if ($files != "." && $files != "..") {
                            echo "<li><a href='$folder/$file/$files'>".$files."</a></li>";
                        }
                    }
                    echo "</ol>";
                }
                else
                {
                    $thelist .= "<li><a href='$folder/$file'>".$file."</a></li>";
                }
            }
        }
    }
    closedir($handle);
?>
<h1>Lista plików w folderze głównym:</h1>
<ul><?php echo $thelist; ?></ul>
</body>
</html>
