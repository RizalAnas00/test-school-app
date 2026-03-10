<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Students
    Route::livewire('students-table', 'students-table')->name('students.index');
    Route::livewire('students/create', 'pages::students.create')->name('students.create');
    Route::livewire('students/{student}', 'pages::students.detail')->name('students.show');
    Route::livewire('students/{student}/edit', 'pages::students.edit')->name('students.edit');

    // Teachers
    Route::livewire('teachers-table', 'teachers-table')->name('teachers.index');
    Route::livewire('teachers/create', 'pages::teachers.create')->name('teachers.create');
    Route::livewire('teachers/{teacher}', 'pages::teachers.detail')->name('teachers.show');
    Route::livewire('teachers/{teacher}/edit', 'pages::teachers.edit')->name('teachers.edit');

    // Academic Classes
    Route::livewire('classes-table', 'classes-table')->name('classes.index');
    Route::livewire('classes/create', 'pages::classes.create')->name('classes.create');
    Route::livewire('classes/{academicClass}', 'pages::classes.detail')->name('classes.show');
    Route::livewire('classes/{academicClass}/edit', 'pages::classes.edit')->name('classes.edit');

    // Parents
    Route::livewire('parents-table', 'parents-table')->name('parents.index');
    Route::livewire('parents/create', 'pages::parents.create')->name('parents.create');
    Route::livewire('parents/{parent}', 'pages::parents.detail')->name('parents.show');
    Route::livewire('parents/{parent}/edit', 'pages::parents.edit')->name('parents.edit');
});

require __DIR__.'/settings.php';
