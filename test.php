<?php
    
    $testNumber = $_GET['test'];
    $testsPathList = glob('uploaded_tests/*.json');

    if (!isset($testsPathList[$testNumber - 1])) {
        http_response_code(404);
        exit;
    } else {
        $currentTest = json_decode(file_get_contents($testsPathList[$testNumber - 1]) ,true);
    }

    $totalQuestions = count($currentTest);
    $correctAnswers = 0;        

    function checkFullAnswers($currentTest) {        
        $continue = true;
        foreach ($currentTest as $key => $test) {
            if (!isset($_POST['question'.($key + 1)])) { 
                
                $continue = false;
            } 
        }
        return $continue;                 
    }

    if (checkFullAnswers($currentTest)) {
        foreach ($currentTest as $key => $test) {
            if ($test['trueAnswer'] === $_POST['question'.($key + 1)]) {
                $correctAnswers++;
            }
        }                 

        $result = round($correctAnswers / $totalQuestions * 100);        
        $resultList = [
            'name' => $_POST['username'],
            'total' => $totalQuestions,
            'correct' => $correctAnswers,
            'result' => $result
        ];
    }

    include_once('certificate.php');  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
    <link rel="stylesheet" href="css/styles.css">  
</head>
<body>    

    <h2>Тест №<?= $testNumber ?></h2>
    
    <? if (!isset($_POST['check'])) : ?>
        <form enctype = "multipart/form-data" action = "" method = "POST" >
            <label>Давайте знакомиться <input type="text" name="username" required="">
           
             <? foreach ($currentTest as $num => $test) : ?>
                <fieldset>
                    <legend><?= $test['question'] ?></legend>

                    <? foreach ($test['varAnswers'] as $var => $questions) : ?>
                        <label><input type="radio" name="question<?= $num + 1 ?>" value="<?= $var ?>"><?= $questions ?></label><br>
                    <? endforeach ?>

                </fieldset>
            <? endforeach ?>        

        <input type="submit" name="check" value="Проверить ответы" style="margin-top: 20px;">
        </form> 
    <? endif ?>
        
    <?if (isset($_POST['check'])) {
        if (!checkFullAnswers($currentTest)) { ?>
            <p>Необходимо ответить на все вопросы</p>                
            <p><a href=''>Вернуться к тесту</a></p>
        <? } else { ?>
            <div>
                <h3>Результаты тестирования пользователя <?= $_POST['username'] ?></h3>
                <p>Всего вопросов: <?= $totalQuestions ?></p>
                <p>Правильных ответов: <?= $correctAnswers ?></p>
                <p>Ваш результат: <?= $result ?>%</p>

                <form method="POST" action="">
                    <input type="hidden" name="results[name]" value="<? echo $resultList['name'] ?>">
                    <input type="hidden" name="results[total]" value="<? echo $resultList['total'] ?>">
                    <input type="hidden" name="results[correct]" value="<? echo $resultList['correct'] ?>">
                    <input type="hidden" name="results[result]" value="<? echo $resultList['result'] ?>">

                    <input type="submit" name="certificate" value="Сгенерировать сертификат">
                </form>
            </div>
        <?}
    }?>   
    
    <br><a href="list.php">Перейти к списку тестов</a>

</body>
</html>