<?php
$plik_tmp = $_FILES['plik']['tmp_name'];
$plik_nazwa = $_FILES['plik']['name'];
$max_rozmiar = 500000;  
$folder = $_COOKIE['nick'];
$temporary_folder = $_POST['folderName'];

if(is_uploaded_file($plik_tmp)) {
    if ($_FILES['plik']['size'] > $max_rozmiar) {
        echo "Przekroczenie rozmiaru $max_rozmiar"; 
    }
    else {  
        if (isset($_FILES['plik']['type'])) {
            echo 'Typ: '.$_FILES['plik']['type'].'<br/>'; 
        }
        if(!empty($temporary_folder)){
            move_uploaded_file($plik_tmp, "$folder/$temporary_folder/$plik_nazwa");
        }
        else {
            move_uploaded_file($plik_tmp, "$folder/$plik_nazwa");
        }
        echo "Plik: <strong>$plik_nazwa</strong> został przesłany na serwer!";
    }
}         
else {
    echo 'Błąd przy przesyłaniu danych!';
}
?>