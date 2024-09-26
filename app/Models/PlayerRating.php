<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerRating extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'mdd_id',
        'user_id',
        'physics',
        'mode',
        'category_rank',
        'category_total_participators',
        'player_records_in_category',
        'last_activity',
        'player_rating',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'mdd_id', 'mdd_id')->select('id', 'name', 'profile_photo_path', 'country', 'mdd_id', 'model');
    }
}
