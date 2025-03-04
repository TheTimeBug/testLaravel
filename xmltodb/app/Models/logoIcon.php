<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logoIcon extends Model
{
    protected $table = 'logo_icons';
    
    protected $fillable = [
        'icon_title',
        'icon_type',
        'icon_tag',
        'icon_location'
    ];
}
