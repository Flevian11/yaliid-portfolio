<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'display_order', 'is_published'])]
class SkillCategory extends Model
{
protected function casts(): array { return ['is_published'=>'boolean']; }
public function skills(): HasMany { return $this->hasMany(Skill::class); }
}
