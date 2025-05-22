<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

     // เฉพาะเส้นทาง API ที่ต้องการเปิด CORS
     'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    // อนุญาตเฉพาะ HTTP methods ที่แอปจำเป็นต้องใช้
    'allowed_methods' => [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ],

    // กำหนด Origins ที่อนุญาตให้เรียก API
    'allowed_origins' => [
        'http://localhost:5173', // สำหรับ dev
        // 'https://app.yourdomain.com',
    ],

    // ถ้าจำเป็นต้อง match pattern (เช่น subdomains) ก็ใช้นี้
    'allowed_origins_patterns' => [
        // '/^https?:\/\/(.*\.)?yourdomain\.com$/',
    ],

    // อนุญาตเฉพาะ headers ที่จำเป็นจริงๆ
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Accept',
        'Authorization',
        'X-CSRF-TOKEN',
    ],

    // Header ที่ browser ให้อ่านได้ (เช่น ถ้าอยาก expose pagination headers)
    'exposed_headers' => [
        // 'X-Total-Count',
    ],

    // เวลา (วินาที) ให้ browser cache preflight request
    'max_age' => 60 * 60, // 1 ชั่วโมง

    // ถ้าใช้ cookie-based auth (เช่น Sanctum CSRF cookie) ให้เป็น true
    // แต่ถ้าใช้ Bearer token อย่างเดียว ก็ควรเป็น false
    'supports_credentials' => true,

];
