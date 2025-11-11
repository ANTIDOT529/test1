<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = strip_tags(trim($_POST["name"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));
    $captcha_input = trim($_POST["captcha"]);
    
    // Валидация обязательных полей
    if (empty($name) || empty($phone)) {
        http_response_code(400);
        echo "Пожалуйста, заполните обязательные поля";
        exit;
    }
    
    // Настройки email
    $to = "kruglovmaksim916@gmail.com";
    $subject = "Новая заявка с сайта Stellar Shots";
    
    // Формирование содержимого письма
    $email_content = "
    <html>
    <head>
        <title>Новая заявка</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
            .field { margin-bottom: 15px; padding: 10px; background: #f9f9f9; }
            .label { font-weight: bold; color: #333; }
            .value { color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2 style='color: #5146c9;'>Новая заявка с сайта Stellar Shots</h2>
            <div class='field'>
                <div class='label'>Имя:</div>
                <div class='value'>$name</div>
            </div>
            <div class='field'>
                <div class='label'>Телефон:</div>
                <div class='value'>$phone</div>
            </div>
            <div class='field'>
                <div class='label'>Сообщение:</div>
                <div class='value'>" . ($message ? nl2br($message) : 'Не указано') . "</div>
            </div>
            <div class='field'>
                <div class='label'>Дата отправки:</div>
                <div class='value'>" . date('d.m.Y H:i:s') . "</div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Заголовки письма
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Stellar Shots <noreply@stellarshots.com>" . "\r\n";
    $headers .= "Reply-To: noreply@stellarshots.com" . "\r\n";
    
    // Отправка письма
    if (mail($to, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(500);
        echo "Ошибка при отправке письма. Пожалуйста, попробуйте позже.";
    }
} else {
    http_response_code(403);
    echo "Доступ запрещен";
}
?>