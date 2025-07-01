<?php

use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'modules' => Module::with('lessons')->get()
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