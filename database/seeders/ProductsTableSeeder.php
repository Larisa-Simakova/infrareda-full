<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Логируем начало выполнения
        Log::info('Starting ProductsTableSeeder');

        try {
            // Очистка таблицы
            DB::table('products')->delete();
            Log::info('Table "products" truncated');

            // Вставка данных
            DB::table('products')->insert([
                [
                    'id' => 8,
                    'title' => 'Водяные инфракрасные панели отопления (ТПИ-28)',
                    'description' => '<p id="isPasted" class="paragraph-normal">Лучистая система отопления &mdash; наиболее рациональная современная техническая система обогрева жилых и нежилых помещений...</p>',
                    'short_description' => '<p class="paragraph-normal">Водяные инфракрасные панели отопления ТПИ-28 &ndash; это современное энергоэффективное решение для обогрева жилых, коммерческих и промышленных помещений.</p>',
                    'created_at' => '2025-05-22 07:39:35',
                    'updated_at' => '2025-05-28 07:59:02',
                ],
                [
                    'id' => 18,
                    'title' => 'Электрические инфракрасные панели отопления (ТПИ-Э)',
                    'description' => '<p id="isPasted" class="paragraph-normal">Инфракрасные панели ТПИ-Э &ndash; это современная альтернатива традиционным системам отопления...</p>',
                    'short_description' => '<p class="paragraph-normal">Электрические инфракрасные панели отопления ТПИ-Э &ndash; инновационное решение для эффективного и экономичного обогрева.</p>',
                    'created_at' => '2025-05-24 00:20:47',
                    'updated_at' => '2025-05-24 00:48:59',
                ],
                [
                    'id' => 19,
                    'title' => 'Двухпоточные воздушно-тепловые завесы',
                    'description' => '<p id="isPasted" class="paragraph-normal">Воздушно-тепловые завесы &ndash; это современное оборудование, которое создает защитный воздушный барьер над входными группами или окнами...</p>',
                    'short_description' => '<p class="paragraph-normal">Двухпоточные воздушно-тепловые завесы &ndash; высокоэффективное решение для поддержания комфортного микроклимата.</p>',
                    'created_at' => '2025-05-24 00:36:50',
                    'updated_at' => '2025-05-24 00:49:22',
                ],
                [
                    'id' => 20,
                    'title' => 'Водяные потолочные излучающие панели (ТПИ-15)',
                    'description' => '<p id="isPasted" class="paragraph-normal">ТПИ-15 представляют собой инновационную систему лучистого отопления, где теплоносителем выступает нагретая вода...</p>',
                    'short_description' => '<p id="isPasted" class="paragraph-normal">Водяные потолочные инфракрасные панели ТПИ-15 – современное решение для эффективного обогрева.</p>',
                    'created_at' => '2025-05-24 00:51:50',
                    'updated_at' => '2025-05-24 00:57:00',
                ],
                [
                    'id' => 21,
                    'title' => 'Всесезонная система микроклимата (ВСМ)',
                    'description' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i247.7bccc921dBVXwt" id="isPasted" class="paragraph-normal">ВСМ представляет собой комплексное оборудование, которое обеспечивает эффективное управление температурой, влажностью и качеством воздуха...</p>',
                    'short_description' => '<p data-spm-anchor-id="a2ty_o01.29997173.0.i246.7bccc921dBVXwt" id="isPasted" class="paragraph-normal">Всесезонная система микроклимата (ВСМ) &ndash; инновационное решение для создания оптимального микроклимата круглый год.</p>',
                    'created_at' => '2025-05-24 00:58:10',
                    'updated_at' => '2025-05-24 01:16:57',
                ],
            ]);

            // Логируем успешное выполнение
            Log::info('ProductsTableSeeder completed successfully');
        } catch (\Exception $e) {
            // Логируем ошибку, если она возникла
            Log::error('ProductsTableSeeder failed: ' . $e->getMessage());
        }
    }
}
