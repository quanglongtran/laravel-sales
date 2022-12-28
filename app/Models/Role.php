<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends ModelsRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'group',
        'guard_name'
    ];

    public function guardName(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => 'web'
        );
    }
}
