<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['experience_id', 'title', 'description', 'display_order', 'is_published'])]
class Achievement extends Model
{
protected function casts(): array { return ['is_published'=>'boolean']; }
public function experience(): BelongsTo { return $this->belongsTo(Experience::class); }
}
