<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class websites extends Model
{
    protected $primaryKey = 'id_website';

    protected $fillable = [
        'name_website',
        'slug',
        'bio',
        'id_template',
        'whatsapp',
        'instagram',
        'logo_path',
        'gallery_photos',
        'gallery_prices',
        ];

    protected function casts(): array
    {
        return [
            'gallery_photos' => 'array',
            'gallery_prices' => 'array',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(templates::class, 'id_template', 'id_template');
    }
}
