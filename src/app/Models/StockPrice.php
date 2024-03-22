<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class StockPrice extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'stock_id',
        'price',
        'previous_price',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }


    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
