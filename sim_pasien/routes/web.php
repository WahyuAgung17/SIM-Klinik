<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/patient.php';
// require __DIR__.'/doctor.php';
// require __DIR__.'/finance.php';
// require __DIR__.'/service.php';
// require __DIR__.'/dashboard.php';

Route::redirect('/', '/patient/dashboard');