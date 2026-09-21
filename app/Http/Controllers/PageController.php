<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Project;
use App\Models\Service;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::orderBy('sort_order')->take(3)->get();
        $projects = Project::orderBy('sort_order')->take(3)->get();
        $articles = Article::latestPublished()->take(3)->get();

        return view('pages.home', compact('services', 'projects', 'articles'));
    }

    public function layananIndex()
    {
        $services = Service::orderBy('sort_order')->get();

        return view('pages.layanan.index', compact('services'));
    }

    public function layananShow(Service $service)
    {
        $relatedProjects = Project::where('service_id', $service->id)->take(3)->get();

        return view('pages.layanan.show', compact('service', 'relatedProjects'));
    }

    public function portofolioIndex()
    {
        $projects = Project::orderBy('sort_order')->get();
        $categories = $projects->pluck('category')->unique()->sort()->prepend('Semua')->values();

        return view('pages.portofolio.index', compact('projects', 'categories'));
    }

    public function portofolioShow(Project $project)
    {
        $project->load('service');

        $otherProjects = Project::whereKeyNot($project->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('pages.portofolio.show', compact('project', 'otherProjects'));
    }

    public function tentang()
    {
        return view('pages.tentang');
    }
}
