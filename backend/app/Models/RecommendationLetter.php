<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['experience_id', 'title', 'issuer_name', 'issuer_position', 'issuer_organization', 'issue_date', 'file_path', 'file_name', 'mime_type', 'file_size', 'description', 'is_published'])]
class RecommendationLetter extends Model
{
protected function casts(): array { return ['issue_date'=>'date','is_published'=>'boolean']; }
public function experience(): BelongsTo { return $this->belongsTo(Experience::class); }
}
