<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Usage;
use Illuminate\Http\Request;

class ProductUsageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'usages' => 'array',
            'usages.*' => 'nullable|string',
            'step' => 'sometimes|string'
        ]);

        try {
            $product->usages()->delete();

            $usages = [];
            foreach ($request->input('usages', []) as $usageTitle) {
                $usageTitle = trim($usageTitle ?? '');
                if (!empty($usageTitle)) {
                    $usages[] = [
                        'title' => $usageTitle,
                        'product_id' => $product->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            if (!empty($usages)) {
                Usage::insert($usages);
            }

            if ($request->input('step') === 'complete') {
                return redirect()->route('view.admin')->with('success', [
                    'message' => 'Изменения успешно сохранены',
                    'type' => 'success'
                ]);
            }

            return redirect()->route('admin.products.edit', [
                'product' => $product->id,
                'step' => 'advantages'
            ])->with('success', [
                        'message' => 'Изменения успешно сохранены',
                        'type' => 'success'
                    ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при сохранении: ' . $e->getMessage());
        }
    }
}
