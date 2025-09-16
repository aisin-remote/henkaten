<?php

use App\Models\Yell;
use App\Models\Skill;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OplController;
use App\Http\Controllers\YellController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\skillController;
use App\Http\Controllers\themeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HenkatenController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkillMatrixController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/auto-update', [HenkatenController::class, 'autoUpdate'])->name('auto-update');
Route::get('/auto-update-status', [HenkatenController::class, 'autoUpdateStatus'])->name('auto-update-status');

Route::get('/admin', function () {
    return view('pages.admin.index');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('pages.auth.login');
    });

    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware(['auth'])->group(function () {
    // default routes
    // Route::get('/', [DashboardController::class, 'index']);
    Route::get('/portal', [DashboardController::class, 'portal']);

    Route::get('line/employees', [EmployeeController::class, 'getEmployees'])->name('line.employees');

    // dashboard
    Route::get('/line/{lineId}/{originId?}', [DashboardController::class, 'dashboardLine'])->name('dashboard.line');
    Route::get('/lineDashboard/{originId?}', [DashboardController::class, 'indexLine'])->name('dashboard.indexLine');
    Route::prefix('dashboard')->group(function () {
        Route::get('{originId?}', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('report', [DashboardController::class, 'report'])->name('dashboard.report');
        Route::get('updateStatus/{lineId}', [DashboardController::class, 'updateLineStatus'])->name('dashboard.line.status');
        Route::get('selectTheme/{theme}', [DashboardController::class, 'selectTheme'])->name('dashboard.theme');
        Route::get('selectFirstPic/{id}', [DashboardController::class, 'selectFirstPic'])->name('dashboard.firstPic');
        Route::get('selectSecondPic/{id}', [DashboardController::class, 'selectSecondPic'])->name('dashboard.SecondPic');
        Route::get('selectSupervisor/{id}', [DashboardController::class, 'selectSupervisor'])->name('dashboard.Supervisor');

        Route::post('storeHenkaten', [HenkatenController::class, 'storeHenkaten'])->name('dashboard.storeHenkaten');
        Route::post('troubleshootHenkaten', [HenkatenController::class, 'troubleshootHenkaten'])->name('dashboard.troubleshootHenkaten');
        Route::post('troubleshootApproval', [HenkatenController::class, 'troubleshootApproval'])->name('dashboard.troubleshootApproval');

        Route::delete('destroy', [HenkatenController::class, 'destroy'])->name('dashboard.henkaten.destroy');
    });

    // get skill for skill matrix
    Route::get('/getSkill', [EmployeeController::class, 'getSkill'])->name('employee.getSkill');

    // employees 
    Route::prefix('/employee')->group(function () {
        // regist employees
        Route::post('/store', [EmployeeController::class, 'employeeStore'])->name('employee.store');

        Route::delete('/destroy/{id}', [EmployeeController::class, 'destroyEmployee'])->name('employee.destroy');

        // planning employees
        Route::get('/planning/{originId?}', [EmployeeController::class, 'employeePlanning'])->name('employeePlanning.index');
        Route::get('/{originId?}', [EmployeeController::class, 'index'])->name('employee.index');
        Route::post('/planning/store', [EmployeeController::class, 'employeePlanningStore'])->name('employeePlanning.store');
        Route::get('/planning/changeShift/{line}/{shift}/{expired}/{newShift}/{newLine?}', [EmployeeController::class, 'editPlanning'])->name('planning.edit');        

        // get employee skill from employee
        Route::get('/getSkillEmp', [EmployeeController::class, 'getSkillEmp'])->name('employee.getSkillEmp');
        Route::get('/getSkillPos', [EmployeeController::class, 'getSkillPos'])->name('employee.getSkillPos');

        // get PIC
        Route::get('/getPic', [EmployeeController::class, 'getPic'])->name('employee.getPic');
        
        // store attendance
        Route::get('/attendance/store', [EmployeeController::class, 'storeAttendance'])->name('attendance.store');
        Route::get('/attendance/rollback', [EmployeeController::class, 'rollbackAttendance'])->name('attendance.rollback');

        // edit employees
        Route::get('/{id}/edit', [EmployeeController::class, 'employeeEdit'])->name('editEmployee');
        Route::post('/{id}/update', [EmployeeController::class, 'employeeUpdate'])->name('employee.update');

        Route::get('/{id}/detail', [EmployeeController::class, 'employeeDetail'])->name('detailEmployee');
        Route::delete('/planning/destroy', [EmployeeController::class, 'destroyPlanning'])->name('employee.planning.destroy');
    });

    // attendance
    Route::get('/attendance/{originId?}', [EmployeeController::class, 'attendance'])->name('attendance.index');

    // regist employee skill
    Route::get('/skill/{originId?}', [skillController::class, 'index'])->name('skill.index');
    Route::prefix('/skill')->group(function () {
        Route::post('/regist', [skillController::class, 'regist'])->name('skill.regist');
        Route::get('/edit/{old}/{new}', [skillController::class, 'editSkill'])->name('skill.edit');
        Route::get('/checkSkill', [skillController::class, 'checkSkill'])->name('skill.checkSkill');
        Route::get('/minimum/{originId?}', [skillController::class, 'minimumIndex'])->name('skill.minimum.index');
        Route::post('/minimumRegist', [skillController::class, 'minimumRegist'])->name('skill.minimum.regist');
        Route::get('/minimumRegist/{id}/edit', [skillController::class, 'minimumRegistEdit'])->name('minimumSkill.edit');
        Route::post('/minimumRegist/{id}', [skillController::class, 'minimumRegistUpdate'])->name('minimumSkill.update');
        Route::delete('/minimum/{id}', [skillController::class, 'destroy'])->name('minimumSkill.destroy');
        Route::delete('/{name}', [skillController::class, 'destroySkill'])->name('skill.destroy');
    });

    Route::get('/history/{originId?}', [HenkatenController::class, 'history'])->name('history');
    Route::get('/safetyThemeHistory/{originId?}', [DashboardController::class, 'safetyThemeHistory'])->name('safety.history');

    // theme
    Route::get('/theme', [themeController::class, 'index'])->name('theme');
    Route::post('/themeStore', [themeController::class, 'regist'])->name('theme.regist');
    Route::post('/theme/{id}', [themeController::class, 'destroy'])->name('theme.destroy');
    
    // theme
    Route::get('/yell', [YellController::class, 'index'])->name('yell');
    Route::post('/yellStore', [YellController::class, 'regist'])->name('yell.regist');
    Route::post('/yell/{id}', [YellController::class, 'destroy'])->name('yell.destroy');
    Route::post('/yell/edit', [YellController::class, 'editYell']);
    
    // henkaten management
    Route::get('/henkatenManagement/{originId?}', [HenkatenController::class, 'henkatenManagementIndex'])->name('henkatenManagement.index');
    Route::post('/henkatenManagement/store', [HenkatenController::class, 'henkatenManagementStore'])->name('henkatenManagement.store');
    Route::get('/henkatenManagement/edit/{table}/{type}/{item}/{newTable}/{newType}/{newItem}', [HenkatenController::class, 'editHankatenManagement'])->name('henkatenManagement.edit');        
    Route::get('/henkatenExport', [HenkatenController::class, 'export'])->name('henkaten.export');
    Route::post('/henkatenImport', [HenkatenController::class, 'henkatenImport'])->name('henkaten.import');
    Route::delete('/henkatenManagement/remove', [HenkatenController::class, 'henkatenManagementRemove'])->name('henkatenManagement.remove');
    
    // OPL 
    Route::prefix('/opl')->group(function () {
        Route::get('/', [OplController::class, 'index']);
        Route::post('/submit-form', [OplController::class, 'handleFormSubmission'])->name('opl.submit');
    });

    Route::prefix('/standard')->group(function () {
        Route::get('/', [StandardController::class, 'index']);
        Route::post('/submit-form', [StandardController::class, 'handleFormSubmission'])->name('standard.submit');
    });

    Route::prefix('/skillMatrix')->group(function () {
        Route::get('/', [SkillMatrixController::class, 'index']);
        Route::post('/submit-form', [SkillMatrixController::class, 'handleFormSubmission'])->name('skillMatrix.submit');
    });

    
    Route::get('/mappingAllLine', function () {
        return view('welcome');
    });

    // logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout.auth');
});
