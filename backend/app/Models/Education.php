<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['institution', 'qualification', 'field_of_study', 'description', 'start_date', 'end_date', 'is_current', 'display_order', 'is_published'])]
class Education extends Model
{
protected function casts(): array { return ['start_date'=>'date','end_date'=>'date','is_current'=>'boolean','is_published'=>'boolean']; }
}
