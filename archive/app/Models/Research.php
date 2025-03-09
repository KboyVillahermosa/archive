<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $fillable = [
        'project_name', 'members', 'abstract', 'document',  'banner_image', 'department', 'approved'
    ];
    
}
