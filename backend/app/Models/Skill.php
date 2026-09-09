<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['skill_category_id', 'name', 'description', 'proficiency', 'display_order', 'is_featured', 'is_published'])]
class Skill extends Model
{
protected function casts(): array { return ['is_featured'=>'boolean','is_published'=>'boolean']; }
public function category(): BelongsTo { return $this->belongsTo(SkillCategory::class,'skill_category_id'); }
}
