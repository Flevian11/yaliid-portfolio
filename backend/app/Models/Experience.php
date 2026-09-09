<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['organization', 'position', 'employment_type', 'location', 'start_date', 'end_date', 'is_current', 'summary', 'description', 'display_order', 'is_published'])]
class Experience extends Model
{
protected function casts(): array { return ['start_date'=>'date','end_date'=>'date','is_current'=>'boolean','is_published'=>'boolean']; }
public function achievements(): HasMany { return $this->hasMany(Achievement::class); } public function recommendationLetters(): HasMany { return $this->hasMany(RecommendationLetter::class); }
}
