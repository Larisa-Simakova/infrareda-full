<?php

namespace App\Http\Controllers;

use App\Models\Characteristic;
use App\Models\Product;
use App\Models\Modification;
use App\Models\ModificationCharacteristic;
use Illuminate\Http\Request;

class ProductCharacteristicController extends Controller
{
    public function storeModification(Product $product, Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        try {
            $modification = $product->modifications()->create([
                'title' => $request->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Модификация добавлена',
                'id' => $modification->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateModification(Product $product, Modification $modification, Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        try {
            $modification->update(['title' => $request->title]);

            return response()->json([
                'success' => true,
                'message' => 'Модификация обновлена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyModification(Product $product, Modification $modification)
    {
        try {
            $modification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Модификация удалена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function finalize(Product $product, Request $request)
    {
        return redirect()->route('admin.products.edit', [
            'product' => $product->id,
            'step' => 'certificates'
        ])->with('success', [
                    'message' => 'Изменения успешно сохранены',
                    'type' => 'success'
                ]);
    }

    public function storeCharacteristic(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        try {
            $characteristic = Characteristic::create([
                'title' => $request->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Характеристика добавлена',
                'id' => $characteristic->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCharacteristic(Characteristic $characteristic, Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        try {
            $characteristic->update(['title' => $request->title]);

            return response()->json([
                'success' => true,
                'message' => 'Характеристика обновлена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyCharacteristic(Characteristic $characteristic)
    {
        try {
            $characteristic->delete();

            return response()->json([
                'success' => true,
                'message' => 'Характеристика удалена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeValue(Product $product, Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'modification_id' => 'required|exists:modifications,id',
            'characteristic_id' => 'required|exists:characteristics,id',
            'value' => 'required|string|max:255'
        ]);

        // Проверка на дубликат только для пары модификация + характеристика
        $exists = ModificationCharacteristic::where('modification_id', $request->modification_id)
            ->where('characteristic_id', $request->characteristic_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => ['value' => ['Для выбранных модификации и характеристики уже существует значение']]
            ], 422);
        }

        try {
            $value = ModificationCharacteristic::create([
                'modification_id' => $request->modification_id,
                'characteristic_id' => $request->characteristic_id,
                'value' => $request->value
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Значение добавлено',
                'id' => $value->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateValue(Product $product, ModificationCharacteristic $value, Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'modification_id' => 'required|exists:modifications,id',
            'characteristic_id' => 'required|exists:characteristics,id',
            'value' => 'required|string|max:255'
        ]);

        // Проверка на дубликат (исключая текущее значение)
        $exists = ModificationCharacteristic::where('modification_id', $request->modification_id)
            ->where('characteristic_id', $request->characteristic_id)
            ->where('id', '!=', $value->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => ['value' => ['Для выбранных модификации и характеристики уже существует значение']]
            ], 422);
        }

        try {
            $value->update([
                'modification_id' => $request->modification_id,
                'characteristic_id' => $request->characteristic_id,
                'value' => $request->value
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Значение обновлено'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyValue(Product $product, ModificationCharacteristic $value)
    {
        try {
            $value->delete();

            return response()->json([
                'success' => true,
                'message' => 'Значение удалено'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка: ' . $e->getMessage()
            ], 500);
        }
    }
}
