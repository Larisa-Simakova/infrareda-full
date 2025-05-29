<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function showMain(Request $request)
    {
        $products_objects = Product::all();
        $objects = Project::all();
        $products = Product::orderBy('id', 'desc')->limit(5)->get();
        $latestBlog = Blog::orderBy('date', 'desc')->first();
        $recentBlogs = Blog::where('id', '!=', $latestBlog->id)
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();
        return view('pages.index', compact('products', 'products_objects', 'objects', 'latestBlog', 'recentBlogs'));
    }

    public function filterObjects(Request $request)
    {
        $productId = $request->input('product_id');

        $query = Project::with('images');

        if ($productId && $productId !== 'all') {
            $query->where('product_id', $productId);
        }

        $objects = $query->get()->map(function ($project) {
            return [
                'title' => $project->title,
                'image_url' => secure_asset('storage/' . $project->images->first()->url),
                'place' => $project->place,
                'date' => $project->date ? $project->date->format('Y-m-d') : null
            ];
        });

        return response()->json(['objects' => $objects]);
    }

    public function showAbout()
    {
        return view('pages.about');
    }

    public function showContacts()
    {
        return view('pages.contacts');
    }
}
