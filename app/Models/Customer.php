<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id;
 * @property string $name;
 * @property string $type;
 * @property string $email;
 * @property string $address;
 * @property string $city;
 * @property string $state;
 * @property string $postal_code;
 * @property $created_at;
 * @property $updated_at;
 * @method static paginate
 * @method static create(array $array)
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
