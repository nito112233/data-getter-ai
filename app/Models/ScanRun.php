<?php

namespace App\Models;

use Database\Factories\ScanRunFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScanRun extends Model
{
    /** @use HasFactory<ScanRunFactory> */
    use HasFactory;

    protected $fillable = [
        'source_id',
        'status',
        'started_at',
        'finished_at',
        'pages_scanned',
        'listings_found',
        'listings_created',
        'listings_updated',
        'error_message',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
