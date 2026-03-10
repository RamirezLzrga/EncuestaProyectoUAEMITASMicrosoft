<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminConfigController;
use App\Http\Controllers\AdminMonitorController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminTemplateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditorDashboardController;
use App\Http\Controllers\EditorSurveyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest', PreventBackHistory::class])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::match(['get', 'post'], '/login/uaemex', [AuthController::class, 'loginUaemex'])->name('login.uaemex');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route for UAEMex Callback (also acts as Editor Dashboard entry point)
Route::match(['get', 'post'], '/editor/dashboard', [AuthController::class, 'uaemexCallback'])
    ->middleware(PreventBackHistory::class)
    ->name('editor.dashboard');

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/perfil', [AuthController::class, 'profile'])->name('profile.show');
    Route::post('/perfil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Rutas de Encuestas
    Route::patch('/surveys/{survey}/toggle-status', [SurveyController::class, 'toggleStatus'])->name('surveys.toggle-status');
    Route::post('/surveys/{survey}/duplicate', [SurveyController::class, 'duplicate'])->name('surveys.duplicate');
    Route::resource('surveys', SurveyController::class);

    // Ruta de Estadísticas
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    Route::middleware(['role:editor'])->prefix('editor')->name('editor.')->group(function () {
        // Route::get('/dashboard', [EditorDashboardController::class, 'index'])->name('dashboard'); // Moved to handle callback

        Route::get('/encuestas/plantillas', [EditorSurveyController::class, 'templates'])->name('encuestas.plantillas');
        Route::get('/encuestas/nueva', [EditorSurveyController::class, 'builderNew'])->name('encuestas.nueva');
        Route::post('/encuestas', [EditorSurveyController::class, 'builderStore'])->name('encuestas.store');
        Route::get('/encuestas/{survey}/editar', [EditorSurveyController::class, 'builderEdit'])->name('encuestas.editar');
        Route::put('/encuestas/{survey}', [EditorSurveyController::class, 'builderUpdate'])->name('encuestas.update');

        Route::get('/encuestas/{survey}/configuracion', [EditorSurveyController::class, 'configuracion'])->name('encuestas.configuracion');
        Route::post('/encuestas/{survey}/configuracion', [EditorSurveyController::class, 'configuracionUpdate'])->name('encuestas.configuracion.update');

        Route::get('/encuestas/{survey}/respuestas', [EditorSurveyController::class, 'respuestas'])->name('encuestas.respuestas');
        Route::get('/encuestas/{survey}/compartir', [EditorSurveyController::class, 'compartir'])->name('encuestas.compartir');
    });

    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Rutas exclusivas para Administradores
    Route::middleware(['role:admin'])->group(function () {
        // Ruta de Bitácora
        Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Rutas de Usuarios
        Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::resource('users', UserController::class);

        // Vistas de administración avanzadas
        Route::get('/admin/aprobaciones', [AdminApprovalController::class, 'index'])->name('admin.aprobaciones');
        Route::post('/admin/aprobaciones/{survey}', [AdminApprovalController::class, 'updateStatus'])->name('admin.aprobaciones.update');
        Route::get('/admin/plantillas', [AdminTemplateController::class, 'index'])->name('admin.plantillas');
        Route::post('/admin/plantillas', [AdminTemplateController::class, 'store'])->name('admin.plantillas.store');
        Route::get('/admin/plantillas/{template}/edit', [AdminTemplateController::class, 'edit'])->name('admin.plantillas.edit');
        Route::put('/admin/plantillas/{template}', [AdminTemplateController::class, 'update'])->name('admin.plantillas.update');
        Route::delete('/admin/plantillas/{template}', [AdminTemplateController::class, 'destroy'])->name('admin.plantillas.destroy');
        Route::get('/admin/reportes', [AdminReportController::class, 'index'])->name('admin.reportes');
        Route::get('/admin/configuracion', [AdminConfigController::class, 'index'])->name('admin.configuracion');
        Route::post('/admin/configuracion', [AdminConfigController::class, 'update'])->name('admin.configuracion.update');
        Route::get('/admin/monitor', [AdminMonitorController::class, 'index'])->name('admin.monitor');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rutas Públicas para responder encuestas
Route::get('/s/{id}', [SurveyController::class, 'showPublic'])->name('surveys.public');
Route::post('/s/{id}', [SurveyController::class, 'storeAnswer'])->name('surveys.store-answer');
Route::get('/s/{id}/thank-you', [SurveyController::class, 'thankYou'])->name('surveys.thank-you');
