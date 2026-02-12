<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class);
    }
}
