<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');

    return response('Application cache cleared successfully.');
})->name('cache.clear');

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin.dashboard');
    
    // User Management
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/admin/users/{user}/profile', [App\Http\Controllers\AdminController::class, 'userProfile'])->name('admin.users.profile');
    Route::post('/admin/users', [App\Http\Controllers\AdminController::class, 'userStore'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'userDestroy'])->name('admin.users.destroy');

    // Content Management
    Route::get('/admin/contents', [App\Http\Controllers\AdminController::class, 'contentsIndex'])->name('admin.contents.index');
    Route::post('/admin/contents', [App\Http\Controllers\AdminController::class, 'contentStore'])->name('admin.contents.store');
    Route::put('/admin/contents/{content}', [App\Http\Controllers\AdminController::class, 'contentUpdate'])->name('admin.contents.update');
    Route::delete('/admin/contents/{content}', [App\Http\Controllers\AdminController::class, 'contentDestroy'])->name('admin.contents.destroy');

    // Course Management
    Route::get('/admin/courses', [App\Http\Controllers\AdminController::class, 'coursesIndex'])->name('admin.courses.index');
    Route::post('/admin/courses', [App\Http\Controllers\AdminController::class, 'courseStore'])->name('admin.courses.store');
    Route::get('/admin/courses/{course}/manage', [App\Http\Controllers\AdminController::class, 'manageCourseContents'])->name('admin.courses.manage');
    Route::put('/admin/courses/{course}', [App\Http\Controllers\AdminController::class, 'courseUpdate'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [App\Http\Controllers\AdminController::class, 'courseDestroy'])->name('admin.courses.destroy');
    // Analytics
    Route::get('/admin/analytics', [App\Http\Controllers\AdminController::class, 'analyticsIndex'])->name('admin.analytics');

    // Settings
    Route::get('/admin/settings', [App\Http\Controllers\AdminController::class, 'settingsIndex'])->name('admin.settings');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [App\Http\Controllers\HomeController::class, 'userIndex'])->name('user.dashboard');
    Route::get('/ask-ai', [App\Http\Controllers\AiController::class, 'index'])->name('ask-ai');

    Route::get('/extension-setup', [App\Http\Controllers\HomeController::class, 'extensionSetup'])->name('extension.install');
    Route::get('/extension-data', [App\Http\Controllers\HomeController::class, 'extensionData'])->name('extension.data');
    Route::post('/extension-data/reset', [App\Http\Controllers\HomeController::class, 'resetExtensionData'])->name('extension.data.reset');

    // Learning / Video
    Route::get('/learn/explore', [App\Http\Controllers\LearningController::class, 'explore'])->name('learn.explore');
    Route::get('/learn/courses/{course}', [App\Http\Controllers\LearningController::class, 'courseView'])->name('course.view');
    Route::get('/learn/{content}', [App\Http\Controllers\LearningController::class, 'watch'])->name('learn.watch');
    Route::post('/learn/progress/save', [App\Http\Controllers\LearningController::class, 'saveProgress'])->name('learn.progress.save');
    
    // Extension verification code for web UI
    Route::post('/extension/verification-codes', [\App\Http\Controllers\Api\Extension\VerificationCodeController::class, 'store'])->name('extension.verify-code');
    Route::post('/extension/device/{device}/revoke', [App\Http\Controllers\HomeController::class, 'revokeDevice'])->name('extension.device.revoke');
});

Route::get('/activity-history', [App\Http\Controllers\HomeController::class, 'activityHistory'])->middleware(['auth', 'verified'])->name('activity.history');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile-settings');
    })->name('profile.edit');

    Route::get('/integrations', function () {
        return view('integrations');
    })->name('integrations');
    Route::get('/bookmarks', [App\Http\Controllers\BookmarkController::class, 'index'])->name('bookmarks');
    Route::post('/bookmarks/{content}/toggle', [App\Http\Controllers\BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::get('/progress', function () {
        return view('progress');
    })->name('progress');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
