<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_id', 'file_path', 'file_name', 'mime_type', 'file_size', 'alt_text', 'caption', 'is_featured', 'display_order'])]
class ProjectMedia extends Model
{
protected function casts(): array { return ['is_featured'=>'boolean']; }
public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
