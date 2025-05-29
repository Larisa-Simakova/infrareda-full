<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CharacteristicsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('characteristics')->delete();
        
        \DB::table('characteristics')->insert(array (
            0 => 
            array (
                'id' => 16,
            'title' => 'Ширина панели (мм)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 17,
            'title' => 'Количество труб (шт)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 18,
            'title' => 'Нормативная теплопроизводительность излучающей панели (Вт/м)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 19,
            'title' => 'Нормативная теплопроизводительность пары коллекторов (Вт)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 20,
                'title' => 'Константа излучающей панели',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 21,
                'title' => 'Константа пары коллекторов',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 22,
                'title' => 'Экспонента излучающей панели',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 23,
                'title' => 'Экспонента пары коллекторов',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 24,
            'title' => 'Объем воды в излучающей панели (л/м)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 25,
            'title' => 'Объем воды в коллекторе (л/шт)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 26,
            'title' => 'Вес панели (кг/м)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 27,
            'title' => 'Вес коллектора (кг/шт)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 28,
                'title' => 'Цвет панели',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 29,
            'title' => 'Размеры панели (ширина х глубина), мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 30,
                'title' => 'Высота панели, мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 31,
                'title' => 'Средняя температура излучающей поверхности, °С',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 32,
                'title' => 'Количество/мощность ступеней нагрева, шт/Вт',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 33,
                'title' => 'Макс. потребляемая электрическая мощность, Вт',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 34,
                'title' => 'Напряжение питания, В',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 35,
                'title' => 'Потребляемый ток, А',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 36,
                'title' => 'Класс пылевлагозащищенности',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 37,
                'title' => 'Защита от перегрева',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 38,
                'title' => 'Тип нагревательного элемента',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 39,
                'title' => 'Тип термостата',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 40,
                'title' => 'Регулировка температуры нагрева',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 41,
                'title' => 'Сетевой кабель с вилкой',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 42,
                'title' => 'Набор крепежных элементов в комплекте',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 43,
                'title' => 'Эффективная высота установки, м',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 44,
                'title' => 'Вес панели, кг',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 45,
                'title' => 'Гарантийный срок, год',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}