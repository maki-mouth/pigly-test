<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeightLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'calories',
        'exercise_time',
        'exercise_content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getExerciseTimeAttribute($value): string
    {
        // null または空文字列の場合は '00:00' を返す
        if (empty($value)) {
            return '00:00';
        }
        // HH:MM:SS の最初の5文字（HH:MM）を切り取る
        return substr($value, 0, 5);
    }

}
