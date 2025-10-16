<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    // List all workouts for the user
    public function index(Request $request): JsonResponse
    {
        $workouts = $request->user()->workouts()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $workouts
        ]);
    }

    // Create a new workout
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'exercise_name' => 'required|string|max:255',
            'muscle_group' => 'required|in:abdominals,abductors,adductors,biceps,calves,cardio,chest,forearms,full body,glutes,hamstrings,lats,lower back,neck,quadriceps,shoulders,traps,triceps,upper back',
            'weight' => 'nullable|string|max:255',
            'reps' => 'required|numeric|min:1',
            'sets' => 'nullable|integer|min:1',
            'workout_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $workout = $request->user()->workouts()->create($validated);

        return response()->json([
            'success' => true,
            'data' => $workout
        ], 201);
    }

    // Get a single workout
    public function show(Request $request, Workout $workout): JsonResponse
    {
        // Authorization Validation
        if ($request->user()->id !== $workout->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $workout
        ]);
    }

    // Update a Workout
    public function update(Request $request, Workout $workout): JsonResponse
    {
        if ($request->user()->id !== $workout->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'exercise_name' => 'sometimes|required|string|max:255',
            'muscle_group' => 'sometimes|required|in:abdominals,abductors,adductors,biceps,calves,cardio,chest,forearms,full body,glutes,hamstrings,lats,lower back,neck,quadriceps,shoulders,traps,triceps,upper back',
            'weight' => 'sometimes|nullable|string|max:255',
            'reps' => 'sometimes|required|numeric|min:1',
            'sets' => 'sometimes|nullable|integer|min:1',
            'workout_date' => 'sometimes|required|date',
            'notes' => 'sometimes|nullable|string',
        ]);

        $workout->update($validated);

        return response()->json([
            'success' => true,
            'data' => $workout
        ]);
    }

    // Delete a workout
    public function destroy(Request $request, Workout $workout): JsonResponse
    {
        // Authorization Validation
        if ($request->user()->id !== $workout->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $workout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Workout deleted successfully'
        ]);
    }
}
