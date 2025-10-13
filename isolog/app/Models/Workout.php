<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workout extends Model
{
    use HasFactory;
    
    /**
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'exercise_name',
        'muscle_group',
        'weight',
        'reps',
        'sets',
        'workout_date',
        'notes',
    ];

    /**
     * @var array<string, string>
     */

    protected $casts = [
        'workout_date' => 'date',
        'reps' => 'float',
        'sets' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
