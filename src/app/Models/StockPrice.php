<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockPrice extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'stock_id',
        'price',
        'previous_price',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
