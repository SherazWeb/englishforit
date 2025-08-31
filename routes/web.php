<?php

use App\Livewire\Auth\LoginModal;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    if (Auth::check()) {
        $firstModule = \App\Models\Module::with('lessons')->orderBy('order')->first();

        if ($firstModule && $firstModule->lessons->isNotEmpty()) {
            $firstLesson = $firstModule->lessons->sortBy('order')->first();

            return redirect()->route('lesson.show', [
                'module' => $firstModule->slug,
                'lesson' => $firstLesson->slug,
            ]);
        }
    }

    return view('welcome', [
        'modules' => \App\Models\Module::with('lessons')->get(),
    ]);
});

// routes/web.php
Route::get('/{module:slug}/{lesson:slug}', function (Module $module, Lesson $lesson) {
    $lesson->load([
        'quiz.questions' => fn($q) => $q->withCount('answers')
    ]);

    $questions = $lesson->quiz->questions;
    $randomQuestions = $questions->count() >= 15
        ? $questions->shuffle()->take(8)
        : $questions;

    $user = Auth::user();

    $maxAttempts = 2;

    $highestScore = QuizAttempt::where('user_id', $user->id)
    ->where('lesson_id', $lesson->id)
    ->max('score');

    $attempt = QuizAttempt::where('user_id', $user->id)
        ->where('lesson_id', $lesson->id)
        ->latest('id')
        ->first();

    if (!$attempt) {
        // No attempt exists, create a new one
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'status' => 'in_progress',
            'attempt_number' => 1,
            'score' => 0,
        ]);
    } elseif (in_array($attempt->status, ['completed', 'almost_perfect']) && $attempt->attempt_number < $maxAttempts) {
        // First attempt completed, start second attempt
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'status' => 'in_progress',
            'attempt_number' => $attempt->attempt_number + 1,
            'score' => 0,
        ]);
    }

    return view('index', [
        'module' => $module,
        'contents' => $lesson,
        'modules' => Module::with('lessons')->get(),
        'questions' => $randomQuestions,
        'latestAttempt' => $attempt,
        'max_score' => $highestScore
    ]);
})->name('lesson.show');


// In your ModuleController or route
Route::get('/{module:slug}', function (Module $module) {
    $firstLesson = $module->lessons()->orderBy('order')->first();
    return redirect()->route('lesson.show', [
        'module' => $module->slug,
        'lesson' => $firstLesson->slug
    ]);
})->name('module.show');

Route::post('/logout', [LoginModal::class, 'logout']);
