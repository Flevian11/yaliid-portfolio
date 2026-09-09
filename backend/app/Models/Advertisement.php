<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'image_path', 'destination_url', 'position', 'start_at', 'end_at', 'is_active', 'display_order'])]
class Advertisement extends Model
{
protected function casts(): array { return ['start_at'=>'datetime','end_at'=>'datetime','is_active'=>'boolean']; }
}
