<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'projectsThisMonth' => Project::where('created_at', '>=', now()->startOfMonth())->count(),
            'serviceCount' => Service::count(),
            'unreadCount' => ContactSubmission::where('is_read', false)->count(),
            'messageCount' => ContactSubmission::count(),
            'recentMessages' => ContactSubmission::latest()->take(5)->get(),
            'recentProjects' => Project::latest('updated_at')->take(3)->get(),
        ]);
    }
}
