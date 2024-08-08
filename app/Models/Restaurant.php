<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = ['vat', 'name_restaurant', 'slug', 'address', 'phone_number', 'logo', 'thumb', 'user_id'];

    /**
     * Get the user that owns the Restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the type that owns the Restaurant
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function types(): belongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
