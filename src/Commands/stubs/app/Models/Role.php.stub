<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\StringCast;
use App\Casts\BooleanCast;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ["name", "label",  "type"];

    public static $listFields = ["id", "name", "label", "type", "created_at", "updated_at"];

    protected $casts = [
        "name" => StringCast::class,
		"label" => StringCast::class,
		"type" => BooleanCast::class,

    ];
}
