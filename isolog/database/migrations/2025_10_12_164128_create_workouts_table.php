<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();

            // Exercise Specific Details
            $table->string('exercise_name');
            $table->enum('muscle_group', [
                'abdominals',
                'abductors',
                'adductors',
                'biceps',
                'calves',
                'cardio',
                'chest',
                'forearms',
                'full body',
                'glutes',
                'hamstrings',
                'lats',
                'lower back',
                'neck',
                'quadriceps',
                'shoulders',
                'traps',
                'triceps',
                'upper back'
            ]);

            // Volume Details
            $table->string('weight')->nullable();
            $table->float('reps');
            $table->integer('sets')->nullable();

            // Tracking
            $table->date('workout_date');
            $table->text('notes')->nullable();

            // Timestamps
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
