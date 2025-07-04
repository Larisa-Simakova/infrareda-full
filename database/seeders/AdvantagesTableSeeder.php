<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdvantagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('advantages')->delete();

        \DB::table('advantages')->insert(array(
            0 =>
                array(
                    'id' => 148,
                    'title' => 'Энергоэффективность',
                    'description' => 'Инфракрасные панели ТПИ-Э обеспечивают экономию электроэнергии до 30-50% по сравнению с традиционными системами отопления. Это достигается за счет прямого нагрева предметов и поверхностей в помещении, а не воздуха.',
                    'traditional_description' => 'Обычные конвекторы и радиаторы нагревают воздух, который поднимается к потолку, создавая значительный перепад температур (у пола холодно, под потолком - жарко). Это приводит к потерям тепла через вентиляцию и требует больше энергии для поддержания комфортной температуры.',
                    'infrared_description' => 'Панели излучают тепловые волны, которые поглощаются полом, стенами, мебелью и другими поверхностями. Нагретые предметы затем равномерно отдают тепло в окружающее пространство, создавая комфортную температуру на уровне человеческого роста.',
                    'img' => 'advantages/CCC7PhOJeQf3fJEDe3YSfyumfVInJmxpk9hGcZaH.svg',
                    'product_id' => 18,
                    'created_at' => '2025-05-24 01:17:35',
                    'updated_at' => '2025-05-24 01:17:35',
                ),
            1 =>
                array(
                    'id' => 149,
                    'title' => 'Быстрый нагрев',
                    'description' => 'Инфракрасные панели начинают отдавать тепло сразу после включения, обеспечивая мгновенный тепловой комфорт.',
                    'traditional_description' => 'Водяные радиаторы и масляные обогреватели требуют времени для прогрева теплоносителя (20-40 минут), а затем еще дополнительное время для прогрева воздуха в помещении (1-2 часа в зависимости от площади).',
                    'infrared_description' => 'Тепловое излучение достигает поверхностей и людей практически мгновенно, без необходимости предварительного прогрева воздуха в помещении. Вы ощущаете тепло уже через 5-7 минут после включения системы.',
                    'img' => 'advantages/m7ifnE71ChEM2LvfPx2XuaOv8bTtqHkfC7Buu6Pm.svg',
                    'product_id' => 18,
                    'created_at' => '2025-05-24 01:17:35',
                    'updated_at' => '2025-05-24 01:17:35',
                ),
            2 =>
                array(
                    'id' => 150,
                    'title' => 'Комфортный микроклимат',
                    'description' => 'Инфракрасные панели создают наиболее физиологичный для человека вид обогрева, аналогичный солнечному теплу.',
                    'traditional_description' => 'Конвекционные системы создают постоянное движение воздуха, что приводит к сквознякам, переносу пыли и аллергенов, а также к пересушиванию воздуха (снижение влажности на 20-30%).',
                    'infrared_description' => 'Тепловые волны нагревают непосредственно тело человека и окружающие поверхности, не вызывая движения воздуха. Это исключает сквозняки, циркуляцию пыли и сохраняет естественную влажность воздуха.',
                    'img' => 'advantages/MSpriLScq6FBT2p4V1XDR7kpRI9uhnkNrHF9OWVR.svg',
                    'product_id' => 18,
                    'created_at' => '2025-05-24 01:17:35',
                    'updated_at' => '2025-05-24 01:17:35',
                ),
            3 =>
                array(
                    'id' => 151,
                    'title' => 'Долговечность и безопасность',
                    'description' => 'Инфракрасные панели отличаются исключительной надежностью и длительным сроком службы.',
                    'traditional_description' => 'Традиционные системы (особенно тепловентиляторы и масляные радиаторы) подвержены износу механических частей, возможны протечки в водяных системах. Открытые нагревательные элементы в некоторых моделях могут представлять опасность.',
                    'infrared_description' => 'Панели не имеют движущихся частей и сложных механизмов. Нагревательные элементы защищены прочным корпусом, температура поверхности не превышает 90°C, что исключает риск ожогов и возгораний. Срок службы - 25 лет и более.',
                    'img' => 'advantages/NEWokZTAEGZY6t6i08fxOJwSbG2bREo8rSHILapd.svg',
                    'product_id' => 18,
                    'created_at' => '2025-05-24 01:17:35',
                    'updated_at' => '2025-05-24 01:17:35',
                ),
            4 =>
                array(
                    'id' => 207,
                    'title' => 'Равномерное распределение тепла',
                    'description' => '<p class="paragraph-normal">Равномерный прогрев помещения по высоте от пола до отопительных панелей. Отсутствие перегретых верхних зон</p>',
                    'traditional_description' => '<p class="paragraph-normal">Весь нагретый теплый воздух остается наверху, в то время как нижняя зона зона остается недогретой</p>',
                    'infrared_description' => '<p class="paragraph-normal">Равномерно распределяют тепло от пола до панелей. Не создают перегретые верхние зоны помещения</p>',
                    'img' => 'products/8/advantages/jVOcvbwAZGJSfxEKejSnD46qDJavDI7f8PP9fDcI.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
            5 =>
                array(
                    'id' => 208,
                    'title' => 'Быстрый нагрев помещения',
                    'description' => '<p class="paragraph-normal">Быстрый прогрев помещения относительно традиционных приборов отопления. В первую очередь греются люди, полы, стены, окружающие предметы. А воздух &mdash; во вторую очередь за счет конвекционного тепла от нагретых поверхностей.</p>',
                    'traditional_description' => '<p class="paragraph-normal">Медленный нагрев, все тепло скапливается наверху, и требуется значительно больше времени для прогрева помещения в зоне работы людей.</p>',
                    'infrared_description' => '<p class="paragraph-normal">В помещениях с высокими потолками, панели нагревают помещение в несколько раз быстрее чем традиционные источники тепла. Чем выше помещение &mdash; тем больше разница. Тепло распределяется равномерно снизу вверх.</p>',
                    'img' => 'advantages/Lv4SsJ4Axco92GsrACzGhajjoMB3DgKB7BUhAOkI.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
            6 =>
                array(
                    'id' => 209,
                    'title' => 'Экономия тепловой энергии',
                    'description' => '<p class="paragraph-normal">Энергосбережение достигается за счет следующих факторов:&nbsp;</p><p class="paragraph-normal">- Низкий градиент температуры по высоте;&nbsp;</p><p class="paragraph-normal">- Увеличенный КПД за счет системы автоматики (при достижении необходимой температуры система начинает работать на рециркуляцию, что снижает потребление теплоносителя);&nbsp;</p><p class="paragraph-normal">- Ощущаемая и результирующая температура (панели обогревают помещение на +18, а человек ощущает температуру 22);&nbsp;</p><p class="paragraph-normal">- Прогрев поступающего инфильтрационного воздуха.</p>',
                    'traditional_description' => '<p class="paragraph-normal">Потребляют много энергии за счет более длительного нагрева помещения. Тепловентиляторы и конвекторы часто выходят из строя, их приходится обслуживать и менять, особенно в производственных помещениях.</p>',
                    'infrared_description' => '<p class="paragraph-normal">За счет быстрого и равномерного нагрева в комплексе с системой автоматики отопительные водяные инфракрасные панели позволяют экономить до 60% за сезон.</p>',
                    'img' => 'advantages/haCAWIpX66Yw9HGwKY2d8f7G3y1Cr02xIYfbertT.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
            7 =>
                array(
                    'id' => 210,
                    'title' => 'Взрывная и пожарная безопасность',
                    'description' => '<p class="paragraph-normal">Для функционирования системы не требуется использование вентиляторов, электричества и иного оборудования, которое может вызвать искры. Конструкция панелей не содержит горючие материалы. Поэтому отсутствует риск возникновения взрыва или пожара.</p>',
                    'traditional_description' => '<p class="paragraph-normal">В работе тепловентиляторов используются движущие элементы, для работы которых требуется электроподключение.</p>',
                    'infrared_description' => '<p class="paragraph-normal">Для обеспечения работы системы необходима только горячая вода.</p>',
                    'img' => 'advantages/a3xZekLFsOOjAK5yD6PYINaxmz7gumMbRZK8CYKb.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
            8 =>
                array(
                    'id' => 211,
                    'title' => 'Высота установки от 3 до 40 метров',
                    'description' => '<p class="paragraph-normal">Воздух в обогреваемом помещении является прозрачным для инфракрасного излучения. Лучистая система первично нагревает пол, стены, предметы и людей.</p>',
                    'traditional_description' => '<p class="paragraph-normal">Перегретый воздух скапливается под потолком и не догревает в зоне нахождения человека.</p>',
                    'infrared_description' => '<p class="paragraph-normal">Равномерное распределение тепла по всей высоте помещения.</p>',
                    'img' => 'advantages/LNlPuMXqkaLfscmFordcyN6KsIGnT6vFSlA38lAd.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
            9 =>
                array(
                    'id' => 212,
                    'title' => 'Возможность зонального обогрева',
                    'description' => '<p class="paragraph-normal">Водяная инфракрасная потолочная система может быть как основным, так и дополнительным отоплением.</p>',
                    'traditional_description' => '<p class="paragraph-normal">Из-за конвекции воздух будет распределяться по всему помещению.</p>',
                    'infrared_description' => '<p class="paragraph-normal">Для зонального обогрева помещения не требуются перегородки.</p>',
                    'img' => 'advantages/MIvoe9zwDzG5old4JKCK8Rscnjz2keLFWdDX015E.svg',
                    'product_id' => 8,
                    'created_at' => '2025-05-28 09:03:04',
                    'updated_at' => '2025-05-28 09:03:04',
                ),
        ));


    }
}
