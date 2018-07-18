<?php
    $testsPathList = glob('uploaded_tests/*.json');

    function showTestsList ($pathList) {
        foreach ($pathList as $num => $test) {
            $singleTest = file_get_contents($test);
            $testNum = 'Тест №'. ($num + 1).'.';
            echo '<li>'.$testNum.'<a href= "test.php?test='.($num + 1).'">Пройти тест</a>'.'</li>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список тестов</title>
    <link rel="stylesheet" href="css/styles.css">  
</head>
<body>

    <h3>Список доступных тестов</h3>
    
    <ul>
        <?php        
            showTestsList($testsPathList);            
        ?>
    </ul>

    <a href="admin.php">Перейти к загрузке тестов</a>

</body>
</html>