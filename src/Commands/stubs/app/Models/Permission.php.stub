<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\StringCast;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = ["name", "label", "module", "parent_id"];

    public static $listFields = ["id", "name", "label", "module", "parent_id", "created_at", "updated_at"];

    public function parent(){
        return $this->belongsTo(Permission::class,"parent_id","id");
    }
    public function children(){
        return $this->hasMany(Permission::class,"parent_id","id");
    }


    protected $casts = [
        "name" => StringCast::class,
		"label" => StringCast::class,
		"module" => StringCast::class,

    ];
}
