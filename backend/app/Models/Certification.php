<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'issuing_organization', 'credential_id', 'credential_url', 'issue_date', 'expiry_date', 'does_not_expire', 'description', 'certificate_file', 'display_order', 'is_published'])]
class Certification extends Model
{
protected function casts(): array { return ['issue_date'=>'date','expiry_date'=>'date','does_not_expire'=>'boolean','is_published'=>'boolean']; }
}
