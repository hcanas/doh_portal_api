<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'short_name',
        'parent_id',
    ];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'credentials');
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'credentials');
    }
    
    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(Office::class, 'parent_id');
    }
}
