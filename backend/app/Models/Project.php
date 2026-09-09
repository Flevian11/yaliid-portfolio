<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'short_description', 'description', 'problem', 'solution', 'results', 'project_type', 'status', 'featured', 'github_url', 'live_url', 'start_date', 'end_date', 'display_order', 'is_published'])]
class Project extends Model
{
protected function casts(): array { return ['featured'=>'boolean','start_date'=>'date','end_date'=>'date','is_published'=>'boolean']; }
public function features(): HasMany { return $this->hasMany(ProjectFeature::class); } public function links(): HasMany { return $this->hasMany(ProjectLink::class); } public function media(): HasMany { return $this->hasMany(ProjectMedia::class); } public function technologies(): HasMany { return $this->hasMany(ProjectTechnology::class); }
}
