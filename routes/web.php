<?php

use App\Livewire\Auth\LoginModal;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    if (Auth::check()) {
        $firstModule = \App\Models\Module::with('lessons')->orderBy('order')->first();

        if ($firstModule && $firstModule->lessons->isNotEmpty()) {
            $firstLesson = $firstModule->lessons->sortBy('order')->first();
            return redirect()->route('lesson.show', [
                'module' => $firstModule->slug,
                'lesson' => $firstLesson->slug
            ]);
        }
    }

    return view('index', [
        'modules' => \App\Models\Module::with('lessons')->get()
    ]);
});

// routes/web.php
Route::get('/{module:slug}/{lesson:slug}', function (Module $module, Lesson $lesson) {
    return view('index', [
        'module' => $module,
        'contents' => $lesson,
        'modules' => Module::with('lessons')->get() // For sidebar
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
