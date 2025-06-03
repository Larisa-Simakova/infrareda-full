<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('view.admin');
        }
        return back()->withErrors(['password' => 'Неверные логин или пароль']);
    }

    public function showAdmin(Request $request)
    {
        $products = Product::orderBy('order')->get();
        return view('pages.admin', compact('products'));
    }

    public function showAdminObjects(Request $request)
    {
        $products = Product::all();

        $query = Project::query();

        if ($request->has('product_id') && $request->product_id != 'all') {
            $query->where('product_id', $request->product_id);
        }

        $objects = $query->paginate(9);

        return view('pages.admin_objects', compact('objects', 'products'));
    }

    public function showAdminBlogs(Request $request)
    {
        $blogs = Blog::paginate(9);
        return view('pages.admin_blogs', compact('blogs'));
    }
}
