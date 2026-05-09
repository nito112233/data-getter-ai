<?php

namespace App\Models;

use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'source_id',
        'scan_run_id',
        'external_id',
        'external_hash',
        'url',
        'title',
        'price_eur',
        'location',
        'seller_name',
        'status',
        'description',
        'detected_specs',
        'image_urls',
        'hardware_score',
        'value_score',
        'risk_score',
        'verdict',
        'confidence',
        'red_flags',
        'pros',
        'cons',
        'questions_to_ask',
        'ai_summary',
        'first_seen_at',
        'last_seen_at',
        'evaluated_at',
    ];

    protected function casts(): array
    {
        return [
            'detected_specs' => 'array',
            'image_urls' => 'array',
            'red_flags' => 'array',
            'pros' => 'array',
            'cons' => 'array',
            'questions_to_ask' => 'array',
            'confidence' => 'decimal:2',
            'first_seen_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'evaluated_at' => 'datetime',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function scanRun(): BelongsTo
    {
        return $this->belongsTo(ScanRun::class);
    }
}
