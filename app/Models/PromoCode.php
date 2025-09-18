<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = ['code', 'type', 'value', 'expires_at'];

    public function isValid()
    {
        return !$this->expires_at || $this->expires_at->isFuture();
    }
}
