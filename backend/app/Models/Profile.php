<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['full_name', 'professional_title', 'tagline', 'bio', 'professional_summary', 'profile_photo', 'hero_image', 'email', 'phone', 'location', 'availability_status', 'availability_text', 'cv_file', 'cv_updated_at', 'is_active'])]
class Profile extends Model
{
protected function casts(): array { return ['cv_updated_at'=>'datetime','is_active'=>'boolean']; }
public function socialLinks(): HasMany { return $this->hasMany(SocialLink::class); }
}
