<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'organization', 'position', 'content', 'photo', 'rating', 'is_featured', 'is_published', 'display_order'])]
class Testimonial extends Model
{
protected function casts(): array { return ['is_featured'=>'boolean','is_published'=>'boolean']; }
}
