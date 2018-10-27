<h1>KU CLOUD</h1>
- composer install
- php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
- php artisan jwt:secret

<h2>Set Up database</h2>
1. file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=KU_CLOUD2
DB_USERNAME=root
DB_PASSWORD=

2. เปลี่ยน charset กับ collation
- config/database.php
     'connections' => [
         ...
         'mysql' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'forge'),
                'username' => env('DB_USERNAME', 'forge'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
     ]
3. php artisan migrate

<h2>User Login</h2>
<table>
    <tr>
        <th>Email</th>
        <th>Password</th>   
    </tr>
    <tr>
        <td>admin@hotmail.com</td>
        <td>secret</td>
    </tr>
    <tr>
        <td>company@hotmail.com</td>
        <td>secret</td>
    </tr>
</table>

<h2>กรณีเขียน ES6</h2>
- npm install
- ให้เขียนไฟล์ไว้ที่ resources/js สร้างโฟลเดอร์ขึ้นมา
- ดูการ map path จาก resources/js มาไว้ที่ public/js ได้ที่ webpack.mix.js
- npm run dev จะทำการ convert ไฟล์ js ให้เป็นเวอร์ชันที่สามารถรันได้ทุก Browser ไฟล์ที่ถูก convert แล้วจะอยู่ใน public/js/... ทีเราตั้งไว้
- npm run watch เมื่อมีการ Save ไฟล์จะทำการ convert ไฟล์ไว้ใน public/js/... ทีเราตั้งไว้ ทันที

<h2>เพิ่มประสิทธิภาพ js</h2>
- npm run prod จะเป็นการบีบอัดไฟล์ js ให้เล็กลงทำให้โหลดได้เร็วขึ้น (ใช้กรณีทำเสร็จทุกอย่างแล้ว)
- การ import / export ไฟล์ ดูตัวอย่าง code ที่ resources/js/static/dashboard.min.js และ resources/js/utility.js
    - import { deepCopy } from '../utility.js';
    - กรณีนี้จะช่วยลดขนาดไฟล์ลงได้ เพราะบางครั้งเราไม่ได้ใช้ function ทั้งหมดในไฟล์ที่เราเรียกมา เราสามารถ import เฉพาะอันที่เราต้องการใช้ได้
- import / export ไม่รองรับการเขียนแบบไม่ผ่านการ convert จาก webpack

<h2>การใช้ online-offline-user</h2> 
- เข้าไปที่โฟลเดอร์ online-offline-user 
- npm install
- สร้างไฟล์ .env

    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=KU_CLOUD2
    DB_USERNAME=root
    DB_PASSWORD=
    JWT_KEY=1JFAi4s5D5L4MYkUgfDHyenLKgnum73d

- JWT_KEY ต้องเหมือนกับ .env ของ laravel
- npm start