<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $categories = Article::categories();
        if ($category && ! isset($categories[$category])) {
            $category = null;
        }

        $featured = Article::latestPublished()->where('is_featured', true)->first();

        $articles = Article::latestPublished()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($featured && ! $category, fn ($q) => $q->where('id', '!=', $featured->id))
            ->paginate(9)
            ->withQueryString();

        $counts = ['semua' => Article::published()->count()]
            + Article::published()->selectRaw('category, count(*) as c')->groupBy('category')->pluck('c', 'category')->all();

        return view('pages.blog.index', compact('articles', 'featured', 'category', 'categories', 'counts'));
    }

    public function show(Request $request, Article $article)
    {
        // Draft/terjadwal hanya bisa dilihat admin yang login (pratinjau)
        if (! $article->isLive() && ! $request->user()) {
            abort(404);
        }

        if ($article->isLive()) {
            $article->increment('views');
        }

        $related = Article::latestPublished()
            ->where('id', '!=', $article->id)
            ->orderByRaw('CASE WHEN category = ? THEN 0 ELSE 1 END', [$article->category])
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('article', 'related'));
    }
}
