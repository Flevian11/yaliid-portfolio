<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'short_description', 'description', 'icon', 'display_order', 'is_featured', 'is_published'])]
class Service extends Model
{
protected function casts(): array { return ['is_featured'=>'boolean','is_published'=>'boolean']; }
public function requests(): HasMany { return $this->hasMany(ServiceRequest::class); }
}
