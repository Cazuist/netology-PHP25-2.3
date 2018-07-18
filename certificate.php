<?php        
    
    if (isset($_POST['certificate'])) {
        $certData = $_POST['results'];

        $line1 = 'Тест №'.$testNumber;
        $line2 = 'Пользователь: ' . $certData['name'];
        $line3 = 'Всего вопросов: ' . $certData['total'];
        $line4 = 'Правильных ответов: ' . $certData['correct'];
        $line5 = 'Ваш результат: ' . $certData['result'] . '%';
        $line6 = date('d F Y');

        $image = imagecreatetruecolor(1350, 964);
        $backColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 15, 90);

        $boxFile = __DIR__.'/img/background2.jpg';
        $imBox = imagecreatefromjpeg($boxFile);

        imagefill($image, 0, 0, $backColor);
        imagecopy($image, $imBox, 0, 0, 0, 0, 1350, 964);

        $fontFile = [
            __DIR__.'/fonts/GalateaGothic.ttf',
            __DIR__.'/fonts/PoeticaChancery.ttf',
            __DIR__.'/fonts/arial.ttf'
        ];

        imagettftext($image, 60, 0, 470, 230, $textColor, $fontFile[0], "Сертификат");
        imagettftext($image, 40, 0, 550, 330, $textColor, $fontFile[2], $line1);
        imagettftext($image, 40, 0, 170, 440, $textColor, $fontFile[2], $line2);
        imagettftext($image, 40, 0, 170, 530, $textColor, $fontFile[2], $line3);
        imagettftext($image, 40, 0, 170, 620, $textColor, $fontFile[2], $line4);
        imagettftext($image, 40, 0, 170, 710, $textColor, $fontFile[2], $line5);
        imagettftext($image, 40, 0, 1000, 750, $textColor, $fontFile[1], $line6);

        header('Content-type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }         
?>