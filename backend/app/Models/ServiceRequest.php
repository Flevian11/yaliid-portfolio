<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['service_id', 'reference', 'name', 'email', 'phone', 'company', 'description', 'budget', 'preferred_deadline', 'status', 'priority', 'admin_notes'])]
class ServiceRequest extends Model
{
protected function casts(): array { return ['preferred_deadline'=>'date']; }
public function service(): BelongsTo { return $this->belongsTo(Service::class); } public function attachments(): HasMany { return $this->hasMany(ServiceRequestAttachment::class); }
}
