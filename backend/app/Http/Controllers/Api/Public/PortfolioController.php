<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\{Profile,Experience,Education,Certification,SkillCategory,Project,Service,Advertisement,Testimonial};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(): JsonResponse
    {
        $profile = Profile::with('socialLinks')->where('is_active', true)->first();

        if ($profile?->cv_file) {
            $profile->cv_file = Storage::disk('public')->url($profile->cv_file);
        }

        return response()->json([
            'profile' => $profile,
            'experiences' => Experience::with(['achievements','recommendationLetters'])->where('is_published',true)->orderBy('display_order')->get(),
            'education' => Education::where('is_published',true)->orderBy('display_order')->get(),
            'certifications' => Certification::where('is_published',true)->orderBy('display_order')->get(),
            'skills' => SkillCategory::with(['skills'=>fn($q)=>$q->where('is_published',true)->orderBy('display_order')])->where('is_published',true)->orderBy('display_order')->get(),
            'projects' => Project::with(['features','links','media','technologies'])->where('is_published',true)->orderBy('display_order')->get(),
            'services' => Service::where('is_published',true)->orderBy('display_order')->get(),
            'advertisements' => Advertisement::where('is_active',true)->orderBy('display_order')->get()->map(function ($advertisement) {
                if ($advertisement->image_path && !str_starts_with($advertisement->image_path, 'http')) {
                    $advertisement->image_path = Storage::disk('public')->url($advertisement->image_path);
                }
                return $advertisement;
            }),
            'testimonials' => Testimonial::where('is_published',true)->orderBy('display_order')->get()->map(function ($testimonial) {
                if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
                    $testimonial->photo = Storage::disk('public')->url($testimonial->photo);
                }
                return $testimonial;
            }),
        ]);
    }

    public function project(Project $project): JsonResponse
    {
        abort_unless($project->is_published,404);
        return response()->json($project->load(['features','links','media','technologies']));
    }

    public function services(): JsonResponse
    {
        return response()->json(Service::where('is_published',true)->orderBy('display_order')->get());
    }

    public function cv(): JsonResponse
    {
        $p = Profile::where('is_active',true)->firstOrFail();

        if ($p->cv_file) {
            $p->cv_file = Storage::disk('public')->url($p->cv_file);
        }

        return response()->json([
            'profile' => $p,
            'experiences' => Experience::with('achievements')->where('is_published',true)->orderBy('display_order')->get(),
            'education' => Education::where('is_published',true)->orderBy('display_order')->get(),
            'certifications' => Certification::where('is_published',true)->orderBy('display_order')->get(),
            'skills' => SkillCategory::with('skills')->where('is_published',true)->orderBy('display_order')->get(),
        ]);
    }
}
