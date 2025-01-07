<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function index()
    {
        if(request('category')){
            Category::where('slug', request('category'))->first();
        }
        $articles = Article::latest()->filter(request([['category']]))->paginate(6)->withQueryString();
        $news = Article::orderByDesc('created_at')->filter(request([['category']]))->take(3)->get();

        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        return view('client.page.akademik.artikel', compact([
            'articles',
            'news',
            'totalVisits',
            'todayVisits',
            'monthVisits',
        ]));
    }


    // public function show(Article $article)
    // {
    //     $article = Article::findOrFail($article->slug)->increment('views');
    //     $news = Article::orderByDesc('created_at')->filter(request('category'))->take(3)->get();

    //     return view('client.page.akademik.artikel.show', compact([
    //         'article',
    //         'news',
    //     ]));
    // }
    public function show(Article $article)
    {
        if(request('category')){
            Category::where('slug', request('category'))->first();
        }
        $article = Article::where('slug', $article->slug)->firstOrFail();
        $article->increment('views');
        $news = Article::orderByDesc('created_at')->filter(request(['category']))->take(3)->get();

        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        return view('client.page.akademik.artikel.show', compact([
            'article', 
            'news',
            'totalVisits',
            'todayVisits',
            'monthVisits',
        ]));
    }
}
