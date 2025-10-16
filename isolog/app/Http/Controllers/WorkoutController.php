<?php

namespace App\Http\Controllers;

// Imports
use App\Models\Workout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class WorkoutController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $workouts = auth()->user()->workouts()->latest()->get();

        return Inertia::render('Workouts/Index', [
            'workouts' => $workouts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Workouts/Create');
    }

    public function store(Request $request)
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

        $workout = auth()->user()->workouts()->create($validated);

        return redirect()->route('workouts.index')
            ->with('message', 'Workout created successfully!');
    }

    public function show(Workout $workout)
    {
        $this->authorize('view', $workout);

        return Inertia::render('Workouts/Show', [
            'workout' => $workout,
        ]);
    }

    public function edit(Workout $workout)
    {
        $this->authorize('update', $workout);

        return Inertia::render('Workouts/Edit', [
            'workout' => $workout,
        ]);
    }

    public function update(Request $request, Workout $workout)
    {
        $this->authorize('update', $workout);
        
        $validated = $request->validate([
            'exercise_name' => 'required|string|max:255',
            'muscle_group' => 'required|string',
            'weight' => 'nullable|string',
            'reps' => 'required|numeric',
            'sets' => 'nullable|integer',
            'workout_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $workout->update($validated);

        return redirect()->route('workouts.index')
            ->with('message', 'Workout updated successfully.');
    }

    public function destroy(Workout $workout) 
    {
        $this->authorize('delete', $workout);
        
        $workout->delete();

        return redirect()->route('workouts.index')
            ->with('message', 'Workout deleted successfully.');
    }
}
