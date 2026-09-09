<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['profile_id', 'platform', 'label', 'url', 'icon', 'display_order', 'is_visible'])]
class SocialLink extends Model
{
protected function casts(): array { return ['is_visible'=>'boolean']; }
public function profile(): BelongsTo { return $this->belongsTo(Profile::class); }
}
