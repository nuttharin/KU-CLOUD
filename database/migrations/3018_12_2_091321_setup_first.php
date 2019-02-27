<?php

use App\TB_COMPANY;
use App\TB_DASHBOARDS;
use App\TB_EMAIL;
use App\TB_PHONE;
use App\TB_STATIC_COMPANY;
use App\TB_USERS;
use App\TB_USER_COMPANY;
use App\TB_USER_CUSTOMER;
use Illuminate\Database\Migrations\Migration;

class SetupFirst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $company = [
            [
                'company_id' => '1',
                'company_name' => 'KU_CLOUD',
                'alias' => 'KU_CLOUD',
                'note' => 'KU_CLOUD',
                'folder_log' => 'KU_CLOUD',
            ],
            [
                'company_id' => '2',
                'company_name' => 'TEST',
                'alias' => 'TEST',
                'note' => 'TEST',
                'folder_log' => 'COMPANY_2',
            ],

        ];

        TB_COMPANY::insert($company);

        $users = [
            [
                'user_id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'ADMIN',
                'lname' => 'ADMIN',
                'type_user' => 'ADMIN',
            ],
            [
                'user_id' => 2,
                'username' => 'company',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'COMPANY',
                'lname' => 'COMPANY',
                'type_user' => 'COMPANY',
            ],
            [
                'user_id' => 3,
                'username' => 'customer',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'fname' => 'CUSTOMER',
                'lname' => 'CUSTOMER',
                'type_user' => 'CUSTOMER',
            ],
        ];

        TB_USERS::insert($users);

        $email_list = [
            [
                'user_id' => 1,
                'email_user' => 'admin@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
            [
                'user_id' => 2,
                'email_user' => 'company@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
            [
                'user_id' => 3,
                'email_user' => 'customer@hotmail.com',
                'is_verify' => true,
                'is_primary' => true,
            ],
        ];

        TB_EMAIL::insert($email_list);

        $phone_list = [
            [
                'user_id' => 1,
                'phone_user' => '0818515125',
                'is_primary' => true,
                'is_verify' => true,
            ],
            [
                'user_id' => 2,
                'phone_user' => '0818515126',
                'is_primary' => true,
                'is_verify' => true,
            ],
            [
                'user_id' => 3,
                'phone_user' => '0818515127',
                'is_primary' => true,
                'is_verify' => true,
            ],
        ];

        TB_PHONE::insert($phone_list);

        TB_USER_COMPANY::insert([
            'user_id' => 1,
            'is_user_main' => true,
            'company_id' => 1,
            'sub_type_user' => 'ADMIN',
        ]);

        TB_USER_COMPANY::insert([
            'user_id' => 2,
            'is_user_main' => true,
            'company_id' => 2,
            'sub_type_user' => 'ADMIN',
        ]);

        TB_USER_CUSTOMER::insert([
            'user_id' => 3,
            'company_id' => 2,
        ]);

        TB_DASHBOARDS::insert([
            'dashboard_id' => 1,
            'user_id' => 2,
            'name' => 'สถานีตัวอย่าง',
            'dashboard' => '[{"x":0,"y":0,"width":12,"height":1,"widget":{"type":"TextBox","download":false,"timeInterval":null,"textbox":"สถานีตัวอย่าง","fontsize":"40"}},{"x":0,"y":1,"width":6,"height":4,"widget":{"type":"TextLine","datasource":"api1.Stations.113.Observe.WindSpeed.Value","download":true,"timeInterval":"2","title_name":"ความเร็วลม จังหวัดตรัง","unit":"km/h","rgb":"#f6b73c"}},{"x":6,"y":1,"width":6,"height":4,"widget":{"type":"TextValue","datasource":["api1.Stations.99.Observe.RelativeHumidity.Value"],"download":false,"timeInterval":"2","title_name":"ความชื้น จังหวัดระนอง","unit":"%","rgb":"#ff0080"}},{"x":0,"y":5,"width":12,"height":4,"widget":{"type":"Table","download":false,"timeInterval":"10","title_name":"สภาพอากาศ","table":{"col_labels":["จังหวัด","Temperature °C","MeanSeaLevelPressure hPa","MaxTemperature °C","MinTemperature °C"],"rows":[{"label":"แม่งฮ่องสอน","data":["api1.Stations.0.Observe.Temperature.Value","api1.Stations.0.Observe.MeanSeaLevelPressure.Value","api1.Stations.0.Observe.MaxTemperature.Value","api1.Stations.0.Observe.MinTemperature.Value"]},{"label":"แพร่","data":["api1.Stations.11.Observe.Temperature.Value","api1.Stations.11.Observe.MeanSeaLevelPressure.Value","api1.Stations.11.Observe.MaxTemperature.Value","api1.Stations.11.Observe.MinTemperature.Value"]},{"label":"ภูเก็ต","data":["api1.Stations.109.Observe.Temperature.Value","api1.Stations.109.Observe.MeanSeaLevelPressure.Value","api1.Stations.109.Observe.MaxTemperature.Value","api1.Stations.109.Observe.MinTemperature.Value"]}]}}},{"x":0,"y":9,"width":6,"height":6,"widget":{"type":"MutiLine","datasource":["api1.Stations.15.Observe.Temperature.Value","api1.Stations.78.Observe.Temperature.Value","api1.Stations.111.Observe.Temperature.Value","api1.Stations.3.Observe.Temperature.Value"],"download":true,"timeInterval":"5","isGroupData":false,"title_name":"Temperature °C","datasets":[{"label":"น่าน (ทุ่งช้าง)","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#f6b73c","borderWidth":2},{"label":"นครปฐม","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#008080","borderWidth":2},{"label":"กระบี่ (เกาะลันตา)","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#ff0080","borderWidth":2},{"label":"เชียงราย","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#00ff00","borderWidth":2}]}},{"x":6,"y":9,"width":6,"height":6,"widget":{"type":"MutiLine","datasource":["api1.Stations.0.Observe.Temperature.Value","api1.Stations.2.Observe.Temperature.Value","api1.Stations.4.Observe.Temperature.Value"],"download":true,"timeInterval":"2","isGroupData":false,"title_name":"อุณหภูมิ","datasets":[{"label":"แม่ฮ่องสอน","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#f6b73c","borderWidth":2},{"label":"เชียงราย","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#ff00ff","borderWidth":2},{"label":"พะเยา","backgroundColor":"rgba(255,255,255,0.0)","borderColor":"#00ff00","borderWidth":2}]}},{"x":0,"y":15,"width":4,"height":5,"widget":{"type":"Gauges","datasource":["api1.Stations.30.Observe.RelativeHumidity.Value"],"download":true,"timeInterval":"10","title_name":"ความชื้น ตาก (เขื่อนภูมิพล) ","opts":{"angle":0,"lineWidth":0.23,"radiusScale":1,"pointer":{"length":0.6,"strokeWidth":0.035,"color":"#000000"},"limitMax":false,"limitMin":false,"colorStart":"#6FADCF","colorStop":"#8FC0DA","strokeColor":"#E0E0E0","generateGradient":true,"highDpiSupport":true,"staticLabels":{"font":"10px Poppins","labels":[0,100],"color":"#000000","fractionDigits":0}},"limitMin":"0","limitMax":"100","unit":"%"}},{"x":4,"y":15,"width":8,"height":5,"widget":{"type":"Radar","datasource":["api1.Stations.53.Observe.Temperature.Value","api1.Stations.53.Observe.RelativeHumidity.Value","api1.Stations.53.Observe.Rainfall.Value","api1.Stations.53.Observe.WindSpeed.Value","api1.Stations.83.Observe.Temperature.Value","api1.Stations.83.Observe.RelativeHumidity.Value","api1.Stations.83.Observe.Rainfall.Value","api1.Stations.83.Observe.WindSpeed.Value","api1.Stations.121.Observe.Temperature.Value","api1.Stations.121.Observe.RelativeHumidity.Value","api1.Stations.121.Observe.Rainfall.Value","api1.Stations.121.Observe.WindSpeed.Value"],"download":false,"timeInterval":"2","datasets":[{},{},{}],"title_name":"สภาพอากาศ","labels":["อุณหภูมิ °C","ความชื้น %","ปริมาณน้ำฝน mm","ความเร็วลม km/h"],"label":["พระนครศรีอยุธยา","ชลบุรี","นราธิวาส"],"color":["#ff0080","#00ff40","#ff8000"]}},{"x":0,"y":20,"width":12,"height":7,"widget":{"type":"Map","datasource":{"groupData":"api1.Stations","latitude":"api1.Stations.[].Latitude.Value","longitude":"api1.Stations.[].Longitude.Value","value":"api1.Stations.[].Observe.Temperature.Value","label":"api1.Stations.[].Province"},"download":false,"timeInterval":"5000","isGroupData":true,"title_name":"อุณหภูมิ เซลเซียส"}}]',
        ]);

        TB_STATIC_COMPANY::insert([
            'static_id' => 1,
            'company_id' => 2,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'weather.nominal.arff',
            'path_file' => 'weather.nominal.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'cpu.arff',
            'path_file' => 'cpu.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'glass.arff',
            'path_file' => 'glass.arff',
            'is_success' => true,
        ]);

        TB_DATA_ANALYSIS::create([
            'user_id' => 2,
            'name' => 'weather.numeric.arff',
            'path_file' => 'weather.numeric.arff',
            'is_success' => true,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
