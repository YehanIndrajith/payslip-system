<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SummaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('employees.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/employee/search/{query}', [EmployeeController::class, 'search'])->name('employee.search');

Route::get('/payslip/{id}/pdf', [PayslipController::class, 'generatePdf'])->name('payslip.pdf');

Route::get('/summary', [SummaryController::class, 'index'])->name('summary');



Route::resource('employees', EmployeeController::class);

Route::resource('payslip', PayslipController::class);





