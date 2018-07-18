<?php

function isValidJSON ($file) {
    return (json_decode($file)) ? true : false;
}

$upploadDir = 'uploaded_tests';
$message = '';

if (isset($_FILES) && isset($_FILES['testfile'])) {
    
    $fileName = strtolower($_FILES['testfile']['name']);
    $filePathTmp = $_FILES['testfile']['tmp_name'];
    
    if ($fileName) {
        $decode = file_get_contents($filePathTmp);

        if (strpos(strtolower($fileName), 'json', -4)) {            
            if (isValidJSON ($decode)) {
                move_uploaded_file($filePathTmp, $upploadDir.'/'.$fileName);

                $message = 'Поздравляем! Ваш тест успешно загружен.';
                header('Location: list.php');
                exit;

            } else {                
                $message = 'Структура файла не JSON!';
            }

        } else {
            $message = 'Загрузите файл с расширением JSON!';
        }

    } else {
        $message = 'Вы должны выбрать файл!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Загрузка тестов</title>
    <link rel="stylesheet" href="css/styles.css">  
</head>
<body>

    <form enctype = "multipart/form-data" action="admin.php" method="POST">
        <input type = "file" name="testfile" style="display: block; margin-bottom: 10px">
        <input type = "submit" value="Загрузить">
    </form>

    <p><pre><?= $message ?></pre></p>
    
</body>
</html>