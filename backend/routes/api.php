<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\PortfolioController;
use App\Http\Controllers\Api\Public\ServiceRequestController;
use App\Http\Controllers\Api\Public\ContactMessageController;
Route::prefix('v1')->group(function(){
 Route::post('/auth/login',[\App\Http\Controllers\Api\AuthController::class,'login']); Route::post('/auth/logout',[\App\Http\Controllers\Api\AuthController::class,'logout'])->middleware('auth'); Route::get('/auth/me',[\App\Http\Controllers\Api\AuthController::class,'me'])->middleware('auth');
 Route::get('/portfolio',[PortfolioController::class,'index']);
 Route::get('/projects/{project:slug}',[PortfolioController::class,'project']);
 Route::get('/services',[PortfolioController::class,'services']);
 Route::get('/cv',[PortfolioController::class,'cv']);
 Route::post('/service-requests',[ServiceRequestController::class,'store']);
 Route::post('/messages',[ContactMessageController::class,'store']);
 Route::middleware(['auth','admin'])->prefix('admin')->group(function(){
 Route::get('/dashboard',[\App\Http\Controllers\Api\Admin\DashboardController::class,'__invoke']);
 Route::apiResource('profile',\App\Http\Controllers\Api\Admin\ProfileController::class)->only(['index','store','show','update']);
 Route::apiResource('experiences',\App\Http\Controllers\Api\Admin\ExperienceController::class);
 Route::apiResource('achievements',\App\Http\Controllers\Api\Admin\AchievementController::class);
 Route::apiResource('education',\App\Http\Controllers\Api\Admin\EducationController::class);
 Route::apiResource('certifications',\App\Http\Controllers\Api\Admin\CertificationController::class);
 Route::apiResource('projects',\App\Http\Controllers\Api\Admin\ProjectController::class);
 Route::apiResource('services',\App\Http\Controllers\Api\Admin\ServiceController::class);
 Route::apiResource('skills',\App\Http\Controllers\Api\Admin\SkillController::class);
 Route::apiResource('advertisements',\App\Http\Controllers\Api\Admin\AdvertisementController::class);
 Route::apiResource('testimonials',\App\Http\Controllers\Api\Admin\TestimonialController::class);
 Route::apiResource('settings',\App\Http\Controllers\Api\Admin\SiteSettingController::class);
 Route::apiResource('service-requests',\App\Http\Controllers\Api\Admin\ServiceRequestController::class)->only(['index','show','update','destroy']);
 Route::apiResource('messages',\App\Http\Controllers\Api\Admin\ContactMessageController::class)->only(['index','show','update','destroy']);
 Route::apiResource('recommendation-letters',\App\Http\Controllers\Api\Admin\RecommendationLetterController::class)->only(['index','store','destroy']);
});
});
