<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем и проверяем данные
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $number = isset($_POST['number']) ? htmlspecialchars(trim($_POST['number'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    $contact_method = isset($_POST['contact_method']) ? htmlspecialchars($_POST['contact_method']) : 'phone';

    // Проверка обязательных полей
    if (empty($username) || empty($number) || empty($message)) {
        die("Пожалуйста, заполните все обязательные поля.");
    }

    // Ваш email (замените на реальный)
    $to = "hotenova31@gmail.com";
    $subject = "Новая заявка от $username";

    // Формируем тело письма
    $body = "
    <html>
    <head>
        <title>$subject</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .data { margin-bottom: 10px; }
            .label { font-weight: bold; color: #6C63FF; }
        </style>
    </head>
    <body>
        <h2 style='color: #6C63FF;'>Новая заявка с сайта</h2>
        
        <div class='data'>
            <span class='label'>Имя:</span> $username
        </div>
        
        <div class='data'>
            <span class='label'>Телефон:</span> $number
        </div>
        
        <div class='data'>
            <span class='label'>Предпочитаемый способ связи:</span> 
            " . ($contact_method == 'phone' ? 'Телефонный звонок' : 'Telegram') . "
        </div>
        
        <div class='data'>
            <span class='label'>Сообщение:</span>
            <div style='margin-top: 5px; padding: 10px; background: #f3f2ec; border-radius: 5px;'>
                $message
            </div>
        </div>
    </body>
    </html>
    ";

    // Заголовки письма
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Сайт-заявка <no-reply@yourdomain.com>\r\n";
    $headers .= "Reply-To: $username <$number>\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Отправка письма
    if (mail($to, $subject, $body, $headers)) {
        // Перенаправление с сообщением об успехе
        header("Location: index.html?status=success");
        exit;
    } else {
        // Перенаправление с сообщением об ошибке
        header("Location: index.html?status=error");
        exit;
    }
} else {
    // Если запрос не POST
    header("Location: index.html");
    exit;
}
?>