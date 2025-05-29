<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects')->delete();
        
        \DB::table('projects')->insert(array (
            0 => 
            array (
                'id' => 14,
                'title' => 'Стадион Ак Барс',
            'description' => '<p id="isPasted" class="custom-h1">Задача:&nbsp;</p><p class="paragraph-normal">Обеспечить комфортный обогрев раздевалок для посетителей катка.</p><p class="paragraph-normal"><br style="margin: 0px; padding: 0px; box-sizing: border-box;"></p><p class="custom-h1">Решение:&nbsp;</p><p class="paragraph-normal">Установили водяные отопительные инфракрасные панели ТПИ-28 на высоте 4 м с веерным расположением (от центра к краям) для эффективного и равномерного прогрева помещения.</p><p class="paragraph-normal"><br style="margin: 0px; padding: 0px; box-sizing: border-box;"></p><p class="custom-h1">Результат:&nbsp;</p><p class="paragraph-normal">Оптимальный микроклимат, энергоэффективность и удобство эксплуатации в условиях ограниченного пространства.</p><p class="paragraph-normal">Идеально для объектов с высокими потолками и нестандартными планировками!</p>',
                'date' => '2021-05-03',
                'place' => 'г. Казань, Татарстан',
                'square' => '1780.00',
                'height' => '5.00',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:36:26',
                'updated_at' => '2025-05-27 23:35:35',
            ),
            1 => 
            array (
                'id' => 16,
                'title' => 'Автосалон ТТС Exeed',
            'description' => '<p class="paragraph-normal"><span style="color: rgb(64, 64, 64); font-family: MontserratMedium, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;" id="isPasted">Установка потолочной лучистой системы водяного отопления ТПИ-28 над потолком грильято в автосалоне ТрансТехСервис Exeed по адресу город Казань ул. Проспект Победы д. 194.</span></p>',
                'date' => '2022-07-03',
                'place' => 'г. Казань, Татарстан',
                'square' => '1000.00',
                'height' => '34.00',
                'product_id' => 20,
                'created_at' => '2025-05-24 01:46:14',
                'updated_at' => '2025-05-27 23:35:54',
            ),
            2 => 
            array (
                'id' => 17,
                'title' => 'Автосалон ТТС BMW',
                'description' => '<p class="paragraph-normal">Потолочное водяное инфракрасное отопление с монтажом под потолок грильято в автосалоне ТрансТехСервис BMW по адресу Оренбург &mdash; Орск, 12-й километр.</p>',
                'date' => '2017-08-07',
                'place' => 'Оренбург — Орск, 12-й километр.',
                'square' => '1100.00',
                'height' => '6.00',
                'product_id' => 8,
                'created_at' => '2025-05-24 01:47:35',
                'updated_at' => '2025-05-27 16:34:46',
            ),
            3 => 
            array (
                'id' => 18,
                'title' => 'Спортзал «Алтын туп»',
            'description' => '<p class="paragraph-normal"><span style="color: rgb(64, 64, 64); font-family: MontserratMedium, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;" id="isPasted">Потолочная инфракрасная система водяного отопления с интегрированным освещением.</span></p>',
                'date' => '2024-05-22',
                'place' => 'с. Богатые Сабы, Татарстан',
                'square' => '1500.00',
                'height' => '6.00',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:50:29',
                'updated_at' => '2025-05-27 23:36:10',
            ),
            4 => 
            array (
                'id' => 19,
                'title' => 'Дом культуры',
                'description' => '<p class="paragraph-normal">Монтаж потолочной инфракрасной системы отопления ТПИ-28 в сельском доме культуры.</p>',
                'date' => '2020-09-09',
                'place' => 'пгт Иштуган, Татарстан',
                'square' => '1954.00',
                'height' => '54.00',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:52:37',
                'updated_at' => '2025-05-27 23:36:18',
            ),
        ));
        
        
    }
}