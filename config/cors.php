<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Cho phép CORS với API
    'allowed_methods' => ['*'], // Cho phép tất cả phương thức (GET, POST, PUT, DELETE, ...)
    'allowed_origins' => ['http://localhost:3000'], // Chỉ cho phép ReactJS truy cập
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Chấp nhận tất cả headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Nếu có dùng xác thực (Sanctum, JWT)
];