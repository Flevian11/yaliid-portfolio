<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\{Project,Experience,ServiceRequest,ContactMessage,Testimonial};
class DashboardController extends Controller { public function __invoke(){return response()->json(['counts'=>['projects'=>Project::count(),'experiences'=>Experience::count(),'service_requests'=>ServiceRequest::where('status','new')->count(),'unread_messages'=>ContactMessage::where('status','unread')->count(),'testimonials'=>Testimonial::count()],'recent_requests'=>ServiceRequest::with('service')->latest()->limit(5)->get(),'recent_messages'=>ContactMessage::latest()->limit(5)->get()]);}}
