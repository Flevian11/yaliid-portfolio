<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Certification;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $recentContent = collect()
            ->merge(Project::query()->latest('updated_at')->limit(2)->get()->map(fn ($x) => [
                'id' => $x->id, 'title' => $x->title, 'type' => 'project',
                'type_label' => 'Project', 'is_published' => (bool) $x->is_published,
                'updated_at' => $x->updated_at,
            ]))
            ->merge(Experience::query()->latest('updated_at')->limit(2)->get()->map(fn ($x) => [
                'id' => $x->id, 'title' => $x->position ?: $x->organization, 'type' => 'experience',
                'type_label' => 'Experience', 'is_published' => (bool) $x->is_published,
                'updated_at' => $x->updated_at,
            ]))
            ->merge(Certification::query()->latest('updated_at')->limit(2)->get()->map(fn ($x) => [
                'id' => $x->id, 'title' => $x->name, 'type' => 'certification',
                'type_label' => 'Certification', 'is_published' => (bool) $x->is_published,
                'updated_at' => $x->updated_at,
            ]))
            ->merge(Skill::query()->latest('updated_at')->limit(2)->get()->map(fn ($x) => [
                'id' => $x->id, 'title' => $x->name, 'type' => 'skill',
                'type_label' => 'Skill', 'is_published' => (bool) $x->is_published,
                'updated_at' => $x->updated_at,
            ]))
            ->merge(Service::query()->latest('updated_at')->limit(2)->get()->map(fn ($x) => [
                'id' => $x->id, 'title' => $x->name, 'type' => 'service',
                'type_label' => 'Service', 'is_published' => (bool) $x->is_published,
                'updated_at' => $x->updated_at,
            ]))
            ->sortByDesc('updated_at')
            ->take(5)
            ->values();

        return response()->json([
            'counts' => [
                'projects' => Project::count(),
                'experiences' => Experience::count(),
                'education' => Education::count(),
                'certifications' => Certification::count(),
                'services' => Service::count(),
                'skills' => Skill::count(),
                'testimonials' => Testimonial::count(),
                'advertisements' => Advertisement::count(),
                'service_requests' => ServiceRequest::where('status', 'new')->count(),
                'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            ],
            'recent_content' => $recentContent,
            'recent_requests' => ServiceRequest::with('service')->latest()->limit(5)->get(),
            'recent_messages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
