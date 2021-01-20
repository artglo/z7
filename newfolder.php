<?php
    $folder = $_COOKIE['nick'];
    $folder_name = $_POST['newfolder'];
    mkdir("$folder/$folder_name");
    echo "<script> window.location = 'panel.php' </script>"
?>