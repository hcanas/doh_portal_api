<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
    
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
