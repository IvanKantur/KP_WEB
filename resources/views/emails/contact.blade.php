<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Новое сообщение с сайта</title>
</head>
<body>
    <h2>Новое сообщение с сайта TechStore</h2>
    
    <p><strong>Отправитель:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Сообщение:</strong></p>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p>Сообщение отправлено через форму обратной связи.</p>
</body>
</html>