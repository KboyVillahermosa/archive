<?php

// app/Models/ResearchDocument.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'members',
        'abstract',
        'file_path',
        'department',
    ];
}
