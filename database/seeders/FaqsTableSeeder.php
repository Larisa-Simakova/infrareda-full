<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faqs')->delete();
        
        \DB::table('faqs')->insert(array (
            0 => 
            array (
                'id' => 19,
                'question' => 'Как работает двухпоточная система?',
                'answer' => '<p>Двухпоточная система создает два параллельных потока воздуха, которые равномерно распределяются по всей высоте проема. Это обеспечивает более эффективную защиту от холода и сквозняков.</p>',
                'product_id' => 19,
                'created_at' => '2025-05-24 00:41:42',
                'updated_at' => '2025-05-24 00:41:42',
            ),
            1 => 
            array (
                'id' => 20,
                'question' => 'Можно ли использовать завесы в жилых помещениях?',
            'answer' => '<p class="paragraph-normal"><span style="color: rgb(0, 0, 0); font-family: system-ui, ui-sans-serif, -apple-system, BlinkMacSystemFont, sans-serif, Inter, NotoSansHans; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: 0.32px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: pre-line; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; float: none; display: inline !important;" id="isPasted">Да, воздушно-тепловые завесы могут быть установлены в частных домах с большими входными дверями или панорамными окнами для защиты от теплопотерь.</span></p>',
                'product_id' => 19,
                'created_at' => '2025-05-24 00:41:42',
                'updated_at' => '2025-05-24 00:41:42',
            ),
            2 => 
            array (
                'id' => 21,
                'question' => 'Какой источник тепла используется в завесах?',
            'answer' => '<p class="paragraph-normal"><span style="color: rgb(0, 0, 0); font-family: system-ui, ui-sans-serif, -apple-system, BlinkMacSystemFont, sans-serif, Inter, NotoSansHans; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: 0.32px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: pre-line; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; float: none; display: inline !important;" id="isPasted">Завесы могут работать как от электричества, так и от водяного теплоносителя, что делает их универсальным решением для разных типов объектов.</span></p>',
                'product_id' => 19,
                'created_at' => '2025-05-24 00:41:42',
                'updated_at' => '2025-05-24 00:41:42',
            ),
            3 => 
            array (
                'id' => 23,
                'question' => 'Можно ли использовать ТПИ-15 как основное отопление?',
                'answer' => '<p class="paragraph-normal">Да, при правильном расчете мощности панели полностью заменяют традиционные системы отопления.</p>',
                'product_id' => 20,
                'created_at' => '2025-05-24 00:54:32',
                'updated_at' => '2025-05-24 00:54:32',
            ),
            4 => 
            array (
                'id' => 24,
                'question' => 'Какова оптимальная высота установки?',
                'answer' => '<p class="paragraph-normal">Рекомендуемая высота монтажа - от 3 до 12 метров, в зависимости от требуемой мощности обогрева.</p>',
                'product_id' => 20,
                'created_at' => '2025-05-24 00:54:32',
                'updated_at' => '2025-05-24 00:54:32',
            ),
            5 => 
            array (
                'id' => 25,
                'question' => 'Требуется ли специальное обслуживание?',
                'answer' => '<p id="isPasted">Нет, система не требует регулярного обслуживания, кроме периодической очистки поверхности.</p>',
                'product_id' => 20,
                'created_at' => '2025-05-24 00:54:32',
                'updated_at' => '2025-05-24 00:54:32',
            ),
            6 => 
            array (
                'id' => 26,
                'question' => 'Совместимы ли с альтернативными источниками тепла?',
                'answer' => '<p class="paragraph-normal">Да, могут работать от любых источников горячей воды: газовых котлов, тепловых насосов, солнечных коллекторов.</p>',
                'product_id' => 20,
                'created_at' => '2025-05-24 00:54:32',
                'updated_at' => '2025-05-24 00:54:32',
            ),
            7 => 
            array (
                'id' => 27,
                'question' => 'Как работает система в режиме охлаждения?',
                'answer' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i257.7bccc921dBVXwt" id="isPasted">В режиме охлаждения ВСМ использует тепловой насос для забора тепла из помещения и его отвода наружу. Это обеспечивает комфортную температуру даже в жаркие дни.</p>',
                'product_id' => 21,
                'created_at' => '2025-05-24 01:00:12',
                'updated_at' => '2025-05-24 01:00:12',
            ),
            8 => 
            array (
                'id' => 28,
                'question' => 'Можно ли использовать ВСМ в частном доме?',
                'answer' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i259.7bccc921dBVXwt" id="isPasted">Да, ВСМ идеально подходит для частных домов. Она обеспечивает круглогодичный комфорт и помогает снизить затраты на коммунальные услуги.</p>',
                'product_id' => 21,
                'created_at' => '2025-05-24 01:00:12',
                'updated_at' => '2025-05-24 01:00:12',
            ),
            9 => 
            array (
                'id' => 29,
                'question' => 'Какие источники энергии используются в системе?',
                'answer' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i260.7bccc921dBVXwt" id="isPasted">ВСМ может работать от электросети, тепловых насосов, солнечных батарей и других источников энергии. Это делает её экологичным и экономичным решением.</p>',
                'product_id' => 21,
                'created_at' => '2025-05-24 01:00:12',
                'updated_at' => '2025-05-24 01:00:12',
            ),
            10 => 
            array (
                'id' => 30,
                'question' => 'Нужно ли обслуживать систему?',
                'answer' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i263.7bccc921dBVXwt" id="isPasted">Регулярное обслуживание минимально и включает проверку фильтров, теплообменников и настройку автоматики. Это гарантирует долговечность и эффективность оборудования.</p>',
                'product_id' => 21,
                'created_at' => '2025-05-24 01:00:12',
                'updated_at' => '2025-05-24 01:00:12',
            ),
            11 => 
            array (
                'id' => 32,
                'question' => 'Можно ли использовать ТПИ-Э как основное отопление?',
            'answer' => '<p style=\'margin: calc(var(--ds-md-zoom)*12px)0; font-size: 16.002px; line-height: var(--ds-md-line-height); color: rgb(64, 64, 64); font-family: DeepSeek-CJK-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, "Open Sans", sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\' id="isPasted" class="paragraph-normal">Да, при правильном расчете мощности панели полностью заменяют традиционное отопление.</p>',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:17:45',
                'updated_at' => '2025-05-24 01:17:45',
            ),
            12 => 
            array (
                'id' => 33,
                'question' => 'Безопасны ли инфракрасные панели для детей и животных?',
            'answer' => '<p class="paragraph-normal"><span style=\'color: rgb(64, 64, 64); font-family: DeepSeek-CJK-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, "Open Sans", sans-serif; font-size: 16.002px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\' id="isPasted">Абсолютно безопасны: нет открытых нагревательных элементов, а температура поверхности не превышает 70-90&deg;C.</span></p>',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:17:45',
                'updated_at' => '2025-05-24 01:17:45',
            ),
            13 => 
            array (
                'id' => 34,
                'question' => 'Как долго служат ИК-панели?',
            'answer' => '<p class="paragraph-normal"><span style=\'color: rgb(64, 64, 64); font-family: DeepSeek-CJK-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, "Open Sans", sans-serif; font-size: 16.002px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\' id="isPasted">&nbsp;Срок службы &ndash; от 25 лет, так как в них нет изнашиваемых деталей.</span></p>',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:17:45',
                'updated_at' => '2025-05-24 01:17:45',
            ),
            14 => 
            array (
                'id' => 35,
                'question' => 'Можно ли регулировать температуру?',
            'answer' => '<p class="paragraph-normal"><span style=\'color: rgb(64, 64, 64); font-family: DeepSeek-CJK-patch, Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, "Open Sans", sans-serif; font-size: 16.002px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\' id="isPasted">Да, с помощью терморегуляторов и умных систем управления (Wi-Fi, GSM).</span></p>',
                'product_id' => 18,
                'created_at' => '2025-05-24 01:17:45',
                'updated_at' => '2025-05-24 01:17:45',
            ),
            15 => 
            array (
                'id' => 45,
                'question' => 'Как долго человеку можно находиться под водяными инфракрасными отопительными приборами?',
            'answer' => '<p>Инфракрасное отопление бывает следующих видов:</p><p>- длинноволновое (время нахождения под приборами не ограничено);</p><p>- коротковолновое (время нахождения под приборами не более 2 часов).</p><p><br></p><p>ТПИ-28 относится к длинноволновым отопительным приборам, так как температура нагрева панели не более 110 градусов и они нагревают только верхние слои кожи без проникновения в глубокие ткани. Также панели не сушат воздух и не поднимают пыль, что делает данное отопление безопасным и полезным для людей.</p>',
                'product_id' => 8,
                'created_at' => '2025-05-28 09:19:07',
                'updated_at' => '2025-05-28 09:19:07',
            ),
        ));
        
        
    }
}