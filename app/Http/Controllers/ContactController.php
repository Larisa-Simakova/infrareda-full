<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductRequestMail; // Создайте этот класс

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:12',
            'city' => 'nullable|string|max:255',
            'product_name' => 'nullable|string|max:255',
            'policy' => 'accepted'
        ]);

        try {
            // Определяем, какое письмо отправлять
            if ($request->has('product_name')) {
                Mail::to('larica.simakova@gmail.com')->send(new ProductRequestMail($validated));
            } else {
                Mail::to('larica.simakova@gmail.com')->send(new ContactFormMail($validated));
            }

            return response()->json([
                'success' => true,
                'message' => 'Сообщение успешно отправлено'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке: ' . $e->getMessage()
            ], 500);
        }
    }
}
