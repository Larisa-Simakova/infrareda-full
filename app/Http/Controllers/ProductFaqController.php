<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Faq;
use Illuminate\Http\Request;

class ProductFaqController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Валидация только если есть заполненные FAQ
        $hasFaqs = false;
        $faqsData = $request->input('faqs', []);

        foreach ($faqsData as $faq) {
            if (!empty($faq['question']) || !empty($faq['answer'])) {
                $hasFaqs = true;
                break;
            }
        }

        if ($hasFaqs) {
            $request->validate([
                'faqs' => 'required|array',
                'faqs.*.question' => 'required|string|max:255',
                'faqs.*.answer' => 'required|string',
            ]);
        }

        try {
            $product->faqs()->delete();

            if ($hasFaqs) {
                foreach ($request->input('faqs', []) as $faq) {
                    if (empty($faq['question'])) continue;

                    Faq::create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                        'product_id' => $product->id
                    ]);
                }
            }

            if ($request->input('step') === 'complete') {
                return redirect()->route('view.admin')->with('success', [
                    'message' => 'Изменения успешно сохранены',
                    'type' => 'success'
                ]);
            }

            return redirect()->route('admin.products.edit', [
                'product' => $product->id,
                'step' => 'description'
            ])->with('success', [
                'message' => 'Изменения успешно сохранены',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при сохранении: ' . $e->getMessage());
        }
    }
}
