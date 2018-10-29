# KU CLOUD 
1. ข้อ 2 ถึง 4 ทำเมื่อ clone project มาครั้งแรก
2. composer install
3. เปลี่ยน .env.example เป็น .env
4. php artisan key:generate
5. php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"
6. php artisan jwt:secret
7. กรณีมีการอัพเดต database พิมพ์ cmd => php artisan migrate:refresh

## Set Up database
1. file .env

            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=KU_CLOUD2
            DB_USERNAME=root
            DB_PASSWORD=


2. เปลี่ยน charset กับ collation config/database.php

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
4. composer dump-autoload
5. php artisan db:seed --class=UsersTableSeeder 

## User Login
| Email               | Password |
| :------------------ | :------- |
| admin@hotmail.com   | secret   |
| company@hotmail.com | secret   |

## กรณีเขียน ES6

- npm install
- ให้เขียนไฟล์ไว้ที่ resources/js สร้างโฟลเดอร์ขึ้นมา
- ดูการ map path จาก resources/js มาไว้ที่ public/js ได้ที่ webpack.mix.js
- npm run dev จะทำการ convert ไฟล์ js ให้เป็นเวอร์ชันที่สามารถรันได้ทุก Browser ไฟล์ที่ถูก convert แล้วจะอยู่ใน public/js/... ทีเราตั้งไว้
- npm run watch เมื่อมีการ Save ไฟล์จะทำการ convert ไฟล์ไว้ใน public/js/... ทีเราตั้งไว้ ทันที

## เพิ่มประสิทธิภาพ js

- npm run prod จะเป็นการบีบอัดไฟล์ js ให้เล็กลงทำให้โหลดได้เร็วขึ้น (ใช้กรณีทำเสร็จทุกอย่างแล้ว)
-  การ import / export ไฟล์ ดูตัวอย่าง code ที่ resources/js/static/dashboard.min.js และ resources/js/utility.js

	- import { deepCopy } from '../utility.js';
	- กรณีนี้จะช่วยลดขนาดไฟล์ลงได้ เพราะบางครั้งเราไม่ได้ใช้ function ทั้งหมดในไฟล์ที่- เราเรียกมา เราสามารถ import เฉพาะอันที่เราต้องการใช้ได้


- import / export ไม่รองรับการเขียนแบบไม่ผ่านการ convert จาก webpack


## การใช้ online-offline-user (node js)
1. เข้าไปที่ .env ของ laravel เพิ่ม

        WS_URL=http://localhost:3000/

2. เพิ่มใน view layout ของตัวเอง

        <meta name="ws_url" content="{{ env('WS_URL') }}">
        <script type="text/javascript" src="{{url('js/Global.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
        <script src="{{url('js/socket.js')}}"></script>

3. เข้าไปที่โฟลเดอร์ online-offline-user 
4. npm install
5. สร้างไฟล์ .env config database และ JWT_KEY

        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=KU_CLOUD2
        DB_USERNAME=root
        DB_PASSWORD=
        JWT_KEY=1JFAi4s5D5L4MYkUgfDHyenLKgnum73d

6. JWT_KEY ต้องเหมือนกับ .env ของ laravel
7. npm start
8. กรณีไม่ได้ใช้เข้าไปที่ public/js/socket.js comment code ทั้งหมด
