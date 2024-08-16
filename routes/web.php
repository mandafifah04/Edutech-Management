<?php

use App\Http\Controllers\Dashboard\Admin\UserAccountController;
use App\Http\Controllers\Dashboard\Auth\{LoginController, LogoutController};
use App\Http\Controllers\Dashboard\Finance\FinanceController;
use App\Http\Controllers\Dashboard\Hrd\{MasterSallaryTrainerController, MasterTrainerController, SallaryReportController, ScheduleClassTrainerController};
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\Kurikulum\{MasterClassKurikulumController, AssignedClassToTrainerController};
use App\Http\Controllers\Dashboard\Trainer\RecapAbsensController;
use App\Http\Controllers\Dashboard\Trainer\TrainerController;
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
    return redirect()->route('login');
});

//login user and admin
Route::get('login', [LoginController::class, 'halamanLogin'])->name('login');
Route::post('login', [LoginController::class, 'JalankanLogikaLogin'])->name('jalankan.login');
//logout user and admin
Route::post('user/logout', [LogoutController::class, 'jalankanLogoutUser'])->name('jalankan.logout.user');
Route::post('admin/logout', [LogoutController::class, 'jalankanLogoutAdmin'])->name('jalankan.logout.admin');


Route::group(['prefix' => 'user', 'middleware' => 'user_middleware:user'], function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [IndexController::class, 'dashboard'])->name('dashboard.utama');
        Route::middleware('roles-hrd:user')->group(function () {
            Route::prefix('hrd')->group(function () {
                Route::prefix('trainer/account')->group(function () {
                    Route::get('/', [MasterTrainerController::class, 'akunTrainer'])->name('hrd.trainer.account.list');
                    Route::post('create', [MasterTrainerController::class, 'buatAkunTrainer'])->name('hrd.trainer.account.create');
                    Route::put('update', [MasterTrainerController::class, 'ubahAkunTrainer'])->name('hrd.trainer.account.update');
                    Route::delete('{id}/delete', [MasterTrainerController::class, 'hapusAkunTrainer'])->name('hrd.trainer.account.delete');
                    Route::prefix('trash')->group(function () {
                        Route::post('restore/{id}', [MasterTrainerController::class, 'restoreByID'])->name('trainer.restore.trash');
                        Route::post('restore', [MasterTrainerController::class, 'restoreAll'])->name('trainer.restore.trash.all');
                        Route::post('delete/{id}', [MasterTrainerController::class, 'deleteByID'])->name('trainer.delete.trash');
                        Route::post('delete', [MasterTrainerController::class, 'deleteAll'])->name('trainer.delete.trash.all');
                    });
                });
                Route::prefix('trainer/sallary')->group(function () {
                    Route::get('/', [MasterSallaryTrainerController::class, 'sallaryTrainer'])->name('hrd.trainer.sallary.list');
                    Route::post('create', [MasterSallaryTrainerController::class, 'buatSallaryTrainer'])->name('hrd.trainer.sallary.create');
                    Route::put('update', [MasterSallaryTrainerController::class, 'ubahSallaryTrainer'])->name('hrd.trainer.sallary.update');
                    Route::delete('{id}/delete', [MasterSallaryTrainerController::class, 'hapusSallaryTrainer'])->name('hrd.trainer.sallary.delete');
                    Route::prefix('trash')->group(function () {
                        Route::post('restore/{id}', [MasterSallaryTrainerController::class, 'restoreByID'])->name('sallary.restore.trash');
                        Route::post('restore', [MasterSallaryTrainerController::class, 'restoreAll'])->name('sallary.restore.trash.all');
                        Route::post('delete/{id}', [MasterSallaryTrainerController::class, 'deleteByID'])->name('sallary.delete.trash');
                        Route::post('delete', [MasterSallaryTrainerController::class, 'deleteAll'])->name('sallary.delete.trash.all');
                    });
                });
                Route::prefix('trainer')->group(function () {
                    Route::prefix('class')->group(function () {
                        Route::get('/', [ScheduleClassTrainerController::class, 'scheduleClass'])->name('hrd.trainer.schedule.list');
                        Route::post('create', [ScheduleClassTrainerController::class, 'buatScheduleTrainer'])->name('hrd.trainer.schedule.create');
                        Route::prefix('schedule')->group(function () {
                            Route::get('{id_kelas}', [ScheduleClassTrainerController::class, 'detailScheduleClass'])->name('hrd.trainer.schedule.detail.list');
                            Route::put('update', [ScheduleClassTrainerController::class, 'ubahScheduleTrainer'])->name('hrd.trainer.schedule.update');
                            Route::delete('{id_kelas}/delete/{id_jadwal}', [ScheduleClassTrainerController::class, 'hapusScheduleTrainer'])->name('hrd.trainer.schedule.delete');
                            Route::prefix('trash')->group(function () {
                                Route::post('restore/{id}/{id_kelas}', [ScheduleClassTrainerController::class, 'restoreByID'])->name('schedule.restore.trash');
                                Route::post('restore/{id_kelas}', [ScheduleClassTrainerController::class, 'restoreAll'])->name('schedule.restore.trash.all');
                                Route::post('delete/{id}/{id_kelas}', [ScheduleClassTrainerController::class, 'deleteByID'])->name('schedule.delete.trash');
                                Route::post('delete/{id_kelas}', [ScheduleClassTrainerController::class, 'deleteAll'])->name('schedule.delete.trash.all');
                            });
                        });
                    });
                });
                Route::prefix('trainer/sallary_report')->group(function () {
                    Route::get('/', [SallaryReportController::class, 'sallaryReportTrainer'])->name('hrd.trainer.sallary_report.list');
                    Route::get('/{users_id}/{kelas_id}/{total_gaji}/confirm', [SallaryReportController::class, 'sallaryReportTrainerConfirm'])->name('hrd.trainer.sallary_report.confirm');
                });
            });
        });
        Route::middleware('roles-kurikulum:user')->group(function () {
            Route::prefix('kurikulum')->group(function () {
                Route::prefix('kelas')->group(function () {
                    Route::get('/', [MasterClassKurikulumController::class, 'kelas'])->name('kurikulum.kelas.list');
                    Route::post('create', [MasterClassKurikulumController::class, 'buatKelas'])->name('kurikulum.kelas.create');
                    Route::put('update', [MasterClassKurikulumController::class, 'ubahKelas'])->name('kurikulum.kelas.update');
                    Route::delete('{id}/delete', [MasterClassKurikulumController::class, 'hapusKelas'])->name('kurikulum.kelas.delete');
                    Route::prefix('trash')->group(function () {
                        Route::post('restore/{id}', [MasterClassKurikulumController::class, 'restoreByID'])->name('kurikulum.kelas.restore.trash');
                        Route::post('restore', [MasterClassKurikulumController::class, 'restoreAll'])->name('kurikulum.kelas.restore.trash.all');
                        Route::post('delete/{id}', [MasterClassKurikulumController::class, 'deleteByID'])->name('kurikulum.kelas.delete.trash');
                        Route::post('delete', [MasterClassKurikulumController::class, 'deleteAll'])->name('kurikulum.kelas.delete.trash.all');
                    });
                    Route::prefix('assigned')->group(function () {
                        Route::get('/', [AssignedClassToTrainerController::class, 'assignedKelas'])->name('kurikulum.assigned.list');
                        Route::post('create', [AssignedClassToTrainerController::class, 'buatAssignedKelas'])->name('kurikulum.assigned.create');
                        Route::put('update', [AssignedClassToTrainerController::class, 'ubahAssignedKelas'])->name('kurikulum.assigned.update');
                        Route::delete('{id}/delete', [AssignedClassToTrainerController::class, 'hapusAssignedKelas'])->name('kurikulum.assigned.delete');
                        Route::prefix('trash')->group(function () {
                            Route::post('restore/{id}', [AssignedClassToTrainerController::class, 'restoreByID'])->name('kurikulum.assigned.restore.trash');
                            Route::post('restore', [AssignedClassToTrainerController::class, 'restoreAll'])->name('kurikulum.assigned.restore.trash.all');
                            Route::post('delete/{id}', [AssignedClassToTrainerController::class, 'deleteByID'])->name('kurikulum.assigned.delete.trash');
                            Route::post('delete', [AssignedClassToTrainerController::class, 'deleteAll'])->name('kurikulum.assigned.delete.trash.all');
                        });
                    });
                });
            });
        });
        Route::middleware('roles-keuangan:user')->group(function () {
            Route::prefix('keuangan')->group(function () {
                Route::get('reports', [FinanceController::class, 'SallaryReports'])->name('keuangan.reports');
                Route::get('{id_sallary}/{status}', [FinanceController::class, 'VerifySallaryReports'])->name('keuangan.verify');
                Route::prefix('recap/export')->group(function () {
                    Route::get('pdf', [FinanceController::class, 'ExportPdfByRecapSallary'])->name('keuangan.recap.export.pdf');
                });
            });
        });
        Route::middleware('roles-trainers:user')->group(function () {
            Route::prefix('trainers')->group(function () {
                Route::get('/', [TrainerController::class, 'kelas'])->name('trainers.kelas');
                Route::prefix('absen')->group(function () {
                    Route::post('jadwal/{id_jadwal}/kelas/{kelas_id}/trainer/{id_trainer}', [TrainerController::class, 'trainerAbsenJadwal'])->name('trainer.absen.jadwal');
                    Route::get('recap', [RecapAbsensController::class, 'recapAbsen'])->name('trainer.recap.absen');
                    Route::prefix('export')->group(function () {
                        Route::get('excel', [RecapAbsensController::class, 'exportExcelByRecapAbsens'])->name('trainer.recap.absen.export.excel');
                        Route::get('pdf', [RecapAbsensController::class, 'exportPdfByRecapAbsen'])->name('trainer.recap.absen.export.pdf');
                    });
                    Route::prefix('trash')->group(function () {
                        Route::post('restore/{id}', [RecapAbsensController::class, 'restoreByID'])->name('trainer.recap.absen.restore.trash');
                        Route::post('restore', [RecapAbsensController::class, 'restoreAll'])->name('trainer.recap.absen.restore.trash.all');
                        Route::post('delete/{id}', [RecapAbsensController::class, 'deleteByID'])->name('trainer.recap.absen.delete.trash');
                        Route::post('delete', [RecapAbsensController::class, 'deleteAll'])->name('trainer.recap.absen.delete.trash.all');
                    });
                });
            });
        });
    });
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin_middleware:admin'], function () {
    Route::get('dashboard', [IndexController::class, 'dashboard'])->name('admin.dashboard');
    Route::prefix('user/account')->group(function () {
        Route::get('/', [UserAccountController::class, 'akunUser'])->name('admin.account.user.list');
        Route::post('create', [UserAccountController::class, 'buatAkunUser'])->name('admin.account.user.create');
        Route::put('update', [UserAccountController::class, 'ubahAkunUser'])->name('admin.account.user.update');
        Route::delete('{id}/delete', [UserAccountController::class, 'hapusAkunUser'])->name('admin.user.account.delete');
    })->name('admin.user.account');
    Route::prefix('trash')->group(function () {
        Route::post('restore/{id}', [UserAccountController::class, 'restoreByID'])->name('restore.trash');
        Route::post('restore', [UserAccountController::class, 'restoreAll'])->name('restore.trash.all');
        Route::post('delete/{id}', [UserAccountController::class, 'deleteByID'])->name('delete.trash');
        Route::post('delete', [UserAccountController::class, 'deleteAll'])->name('delete.trash.all');
    });
});
