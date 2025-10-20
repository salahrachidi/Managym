<?php


use App\Models\personnel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\coacheController;
use App\Http\Controllers\muscleController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\machineController;
use App\Http\Controllers\packageController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\personnelController;
use App\Http\Controllers\machine_muscleController;
use App\Http\Controllers\muscle_machineController;
use App\Http\Controllers\NotifiactionsController;
use App\Http\Controllers\transformationController;
use App\Http\Controllers\pdfController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return redirect('/login');
});


Route::get('/', function () {
    return redirect('/home');
});

Route::middleware('isAlreadyLoggedIn')->group(function(){
    Route::get('/home', [authController::class, 'index']);
    Route::get('/home/login', [authController::class, 'login']);
    Route::post('/Plogin', [authController::class, 'Plogin']);
    Route::get('/home/register', [authController::class, 'register']);
    Route::post('/home/register/store', [authController::class,'Pregister'])->name('storeUser');

});
Route::get('/logout', [authController::class, 'logout']);

Route::middleware('isLoggedIn')->group(function () {

    //hna adir aya route ye9der user yewsal lih walakin admin la
    Route::middleware(['IsAdmin', 'IsNewUser'])->group(function () {
        Route::get('/profile', [profileController::class, 'index']);
        Route::get('/profile/account', [profileController::class, 'account']);
        Route::get('/profile/transformation', [profileController::class, 'transformation']);
        Route::get('/profile/password', [profileController::class, 'password']);

        //update user
        Route::post('/profile/account/{id}/update-user', [profileController::class, 'updateUser'])->name('updateUser');
        Route::post('/addTransUser/profile/{id}', [profileController::class, 'addTransUser'])->name('addTransUser');
        Route::post('/profile/change-password', [profileController::class, 'updatePassword'])->name('update-password');
    });

    //Routes li ki9der yewsal lihom member jded
    Route::get('/AccountActivation/{id}', [authController::class, 'ActivateAccount']);
    Route::get('pdf/{id}', [pdfController::class, 'PDf']);


    //hna adir aya route khas ghir l admin yewsal lih ol user la
    Route::middleware('IsUser')->group(function () {
        // ;; CREATE ADMIN
        Route::get('/createAdmin', [UserController::class, 'createAdmin'])->name('createAdmin');
        Route::post('/createAdmin/storeAdmin', [UserController::class, 'storeAdmin'])->name('storeAdmin');
        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Search
        Route::post('/members/searchMember', [searchController::class, 'searchMember'])->name('member.search');
        Route::post('/coaches/searchCoache', [searchController::class, 'searchCoache'])->name('coache.search');
        Route::post('/transformations/searchTrans', [searchController::class, 'searchTrans'])->name('trans.search');
        Route::post('/packages/searchPack', [searchController::class, 'searchPack'])->name('package.search');
        Route::post('/muscles/searchMusc', [searchController::class, 'searchMusc'])->name('muscle.search');
        Route::post('/machines/searchMach', [searchController::class, 'searchMach'])->name('machine.search');
        Route::post('/payments/searchPay', [searchController::class, 'searchPay'])->name('pay.search');
        //members Crud Routes
        Route::resource('/members', personnelController::class);
        //coaches Crud Routes
        Route::resource('/coaches', coacheController::class);
        //Transformations Routes
        Route::resource('/transformations', transformationController::class);
        //packages Routes
        Route::resource('/packages', packageController::class);
        //muscles Routes
        Route::resource('/muscles', muscleController::class);
        //machines Routes
        Route::resource('/machines', machineController::class);
        //machine_muscle Routes
        Route::get('/mus_macs/{id}', [machine_muscleController::class, 'assign']);
        Route::POST('/mus_macs/store', [machine_muscleController::class, 'store']);
        //muscle_machine Routes
        Route::get('/mac_muss/{id}', [muscle_machineController::class, 'assign']);
        Route::POST('/mac_muss/store', [muscle_machineController::class, 'store']);
        //payments Routes
        Route::get('/payments', [paymentController::class, 'Pre_index']);
        Route::get('/payments/{id}', [paymentController::class, 'index']);
        Route::get('/payments/{id}/create', [paymentController::class, 'create']);
        Route::post('/payments', [paymentController::class, 'store']);
        Route::delete('/payments/{id}', [paymentController::class, 'destroy']);
        //notifications Routes
        Route::delete('/notifiaction/{id}/destroy',[NotifiactionsController::class,'destroy']);
        Route::delete('/notification/clear',[NotifiactionsController::class,'clearAll']);
        Route::delete('/notification/clearpa',[NotifiactionsController::class,'clearpa']);

    });
});

        // Route::resource('/members', personnelController::class);





// ///// home
// //login
// Route::get('/login', [authController::class, 'login'])->middleware('isAlreadyLoggedIn');
// Route::post('/Plogin', [authController::class, 'Plogin']);
// //register
// Route::get('/register', [authController::class, 'register'])->middleware('isAlreadyLoggedIn');
// Route::post('/Pregister', [authController::class, 'Pregister']);
// //logout







//members Crud Routes
        // Route::resource('/members', personnelController::class);
