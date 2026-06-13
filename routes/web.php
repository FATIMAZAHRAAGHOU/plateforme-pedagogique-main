<?php
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('accueil');
})->name('accueil');

Route::resource('filieres', FiliereController::class)->except(['show'])->middleware('auth');
Route::resource('groupes', GroupeController::class)->except(['show'])->middleware('auth');
Route::resource('etudiants', EtudiantController::class)->except(['show'])->middleware('auth');
Route::resource('enseignants', EnseignantController::class)->except(['show'])->middleware('auth');
Route::resource('modules', ModuleController::class)->except(['show'])->middleware('auth');
Route::resource('seances', SeanceController::class)->except(['show'])->middleware('auth');
Route::resource('presences', PresenceController::class)->except(['show'])->middleware('auth');
Route::resource('evaluations', EvaluationController::class)->except(['show'])->middleware('auth');
Route::resource('notes', NoteController::class)->except(['show'])->middleware('auth');
Route::resource('cours', CoursController::class)->middleware('auth');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



Route::get('/admin/dashboard', function () {
    if (auth()->user()->role != 'admin') {
        abort(403);
    }

    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::get('/enseignant/dashboard', function () {
    if (auth()->user()->role != 'enseignant') {
        abort(403);
    }

    return view('enseignant.dashboard');
})->middleware('auth')->name('enseignant.dashboard');

Route::get('/etudiant/dashboard', function () {
    if (auth()->user()->role != 'etudiant') {
        abort(403);
    }

    return view('etudiant.dashboard');
})->middleware('auth')->name('etudiant.dashboard');




Route::resource('users', UserController::class)
    ->except(['show'])
    ->middleware('auth');
