<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['service_request_id', 'file_path', 'file_name', 'mime_type', 'file_size', 'description'])]
class ServiceRequestAttachment extends Model
{
public function serviceRequest(): BelongsTo { return $this->belongsTo(ServiceRequest::class); }
}
