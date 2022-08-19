<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('re', 'phpmailer/language/');
	$mail->IsHTML(true);
	
	// от кого письмо
	$mail->setForm('alecsandrgladkiy@gmail.com', 'Фрилансер по жизни');
	// кому отправить>
	$mail->addAddress('alexair.g@yandex.ru');
	// тема письма
	$mail->Subject = 'Привет, это фрилансер по жизни';

	// пол
	$hand = "Мужской";
	if ($_POST['hand'] == "left") {
		$hand = "Женский";
	}

	// тело письма
	$body = '<h1>встречайте супер письмо</h1>';

	if (trim(!empty($_POST['name']))) {
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if (trim(!empty($_POST['email']))) {
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if (trim(!empty($_POST['hand']))) {
		$body.='<p><strong>Пол:</strong> '.$hand.'</p>';
	}
	if (trim(!empty($_POST['age']))) {
		$body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
	}
	if (trim(!empty($_POST['message']))) {
		$body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
	}

	// прикрепить файлы
	if (!empty($_FILES['image']['tmp_name'])) {
		// путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
		// грузим файл
		if(copy($_FILES['image']['tmp_name'], $filePath)) {
			$fileAttach = $filePath;
			$body.='<p><strong>фото в приложении</strong></p>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	// отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	}else{
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);

	?>