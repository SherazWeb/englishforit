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

    $latestAttempt = null;
    if ($user) {
        $latestAttempt = QuizAttempt::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->first();
    }

    return view('index', [
        'module'        => $module,
        'contents'      => $lesson,
        'modules'       => Module::with('lessons')->get(),
        'questions'     => $randomQuestions,
        'latestAttempt' => $latestAttempt,
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
