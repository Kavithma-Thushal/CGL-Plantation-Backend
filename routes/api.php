<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\PackageMediaController;
use App\Http\Controllers\PlanTemplateController;
use App\Http\Controllers\PackageTimelineController;
use App\Http\Controllers\QuotationRequestController;
use App\Http\Controllers\AdministrativeLevelController;
use App\Http\Controllers\AdministrativeHierarchyController;
use App\Http\Controllers\EmployeeBranchController;
use App\Http\Controllers\UserController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/user', [UserController::class, 'getUser']);
        Route::patch('/user', [UserController::class, 'updateProfile']);
        Route::patch('/user-profile/password', [AuthController::class, 'changePassword']);

        Route::post('/change-password', [AuthController::class, 'changePassword']);


        Route::prefix('customers')->group(function () {
            Route::get('', [CustomerController::class, 'getAll'])->middleware('permissions:customers-view-all');
            Route::get('{id}', [CustomerController::class, 'getById'])->middleware('permissions:customers-view-all');
            Route::patch('{id}', [CustomerController::class, 'update'])->middleware('permissions:customers-update');
        });

        Route::prefix('employee-branches')->group(function () {
            Route::put('current-branch', [EmployeeBranchController::class, 'update']);
        });

        Route::prefix('designations')->group(function () {
            Route::get('tree', [DesignationController::class, 'getTree'])->middleware(['permissions:designations-tree']);
            Route::put('{id}', [DesignationController::class, 'update'])->middleware(['permissions:designations-update']);
            Route::delete('{id}', [DesignationController::class, 'delete'])->middleware(['permissions:designations-delete']);
            Route::get('{id}', [DesignationController::class, 'getById'])->middleware(['permissions:designations-view']);
            Route::post('', [DesignationController::class, 'add'])->middleware(['permissions:designations-add']);
            Route::get('', [DesignationController::class, 'getAll'])->middleware(['permissions:designations-view-all']);
        });

        Route::prefix('administrative-levels')->group(function () {
            Route::get('{id}', [AdministrativeLevelController::class, 'getById'])->middleware(['permissions:administrative-levels-view']);
            Route::put('{id}', [AdministrativeLevelController::class, 'update'])->middleware(['permissions:administrative-levels-update']);
            Route::delete('{id}', [AdministrativeLevelController::class, 'delete'])->middleware(['permissions:administrative-levels-delete']);
            Route::post('', [AdministrativeLevelController::class, 'add'])->middleware(['permissions:administrative-levels-add']);
            Route::get('', [AdministrativeLevelController::class, 'getAll'])->middleware(['permissions:administrative-levels-view-all']);
        });

        Route::prefix('administrative-hierarchies')->group(function () {
            Route::put('{id}', [AdministrativeHierarchyController::class, 'update'])->middleware(['permissions:administrative-hierarchies-update']);
            Route::delete('{id}', [AdministrativeHierarchyController::class, 'delete'])->middleware(['permissions:administrative-hierarchies-delete']);
            Route::get('{id}', [AdministrativeHierarchyController::class, 'getById'])->middleware(['permissions:administrative-hierarchies-view']);
            Route::post('', [AdministrativeHierarchyController::class, 'add'])->middleware(['permissions:administrative-hierarchies-add']);
            Route::get('', [AdministrativeHierarchyController::class, 'getAll'])->middleware(['permissions:administrative-hierarchies-view-all']);
        });

        Route::prefix('plan-templates')->group(function () {
            Route::get('{id}', [PlanTemplateController::class, 'getById'])->middleware(['permissions:plan-templates-view']);
            Route::get('', [PlanTemplateController::class, 'getAll'])->middleware(['permissions:plan-templates-view-all']);
        });

        Route::prefix('plans')->group(function () {
            Route::get('{id}', [PlanController::class, 'getById'])->middleware(['permissions:plans-view']);
            Route::put('{id}', [PlanController::class, 'update'])->middleware(['permissions:plans-update']);
            Route::delete('{id}', [PlanController::class, 'delete'])->middleware(['permissions:plans-delete']);
            Route::post('', [PlanController::class, 'add'])->middleware(['permissions:plans-add']);
            Route::get('', [PlanController::class, 'getAll'])->middleware(['permissions:plans-view-all']);
        });

        Route::prefix('master-data')->group(function () {
            Route::get('/titles', [MasterDataController::class, 'getTitles'])->middleware(['permissions:master-data-titles-view']);
            Route::get('/banks', [MasterDataController::class, 'getBanks'])->middleware(['permissions:master-data-banks-view']);
            Route::get('/branches', [MasterDataController::class, 'getBranches'])->middleware(['permissions:master-data-branches-view']);
            Route::get('/roles', [MasterDataController::class, 'getRoles'])->middleware(['permissions:master-data-roles-view']);
            Route::get('/races', [MasterDataController::class, 'getRaces'])->middleware(['permissions:master-data-races-view']);
            Route::get('/nationalities', [MasterDataController::class, 'getNationalities'])->middleware(['permissions:master-data-nationalities-view']);
            Route::get('/occupations', [MasterDataController::class, 'getOccupations'])->middleware(['permissions:master-data-occupations-view']);
            Route::get('/countries', [MasterDataController::class, 'getCountries'])->middleware(['permissions:master-data-countries-view']);
            Route::get('/tree-brands', [MasterDataController::class, 'getTreeBrands'])->middleware(['permissions:master-data-tree-brands-view']);
        });

        Route::prefix('employees')->group(function () {
            Route::get('/by-nic/{nic}', [EmployeeController::class, 'getByNIC'])->middleware(['permissions:employees-view-by-nic']);
            Route::post('', [EmployeeController::class, 'add'])->middleware(['permissions:employees-add']);
            Route::post('bulk-import', [EmployeeController::class, 'bulkImport'])->middleware(['permissions:employees-add']);
            Route::put('{id}', [EmployeeController::class, 'update'])->middleware(['permissions:employees-update']);
            Route::delete('{id}', [EmployeeController::class, 'delete'])->middleware(['permissions:employees-delete']);
            Route::get('{id}', [EmployeeController::class, 'getById'])->middleware(['permissions:employees-view']);
            Route::get('', [EmployeeController::class, 'getAll'])->middleware(['permissions:employees-view-all']);
        });

        Route::prefix('quotations')->group(function () {
            Route::post('', [QuotationController::class, 'add'])->middleware(['permissions:quotations-add']);
            Route::put('{id}', [QuotationController::class, 'update'])->middleware(['permissions:quotations-update']);
            Route::get('{id}/file', [QuotationController::class, 'getPDF'])->middleware(['permissions:quotations-get-pdf']);
            Route::get('{id}', [QuotationController::class, 'getById'])->middleware(['permissions:quotations-view']);
            Route::get('', [QuotationController::class, 'getAll'])->middleware(['permissions:quotations-view-all']);
        });

        Route::prefix('quotation-requests')->group(function () {
            Route::get('{id}', [QuotationRequestController::class, 'getById'])->middleware(['permissions:quotation-requests-view']);
            Route::get('{id}/file', [QuotationRequestController::class, 'getPDF'])->middleware(['permissions:quotations-request-get-pdf']);
            Route::get('', [QuotationRequestController::class, 'getAll'])->middleware(['permissions:quotation-requests-view-all']);
        });

        Route::prefix('package-timeline')->group(function () {
            Route::post('update', [PackageTimelineController::class, 'updateTimeline'])->middleware(['permissions:package-timeline-update']);
            Route::post('supervisor-approve', [PackageTimelineController::class, 'supervisorApprove'])->middleware(['permissions:package-timeline-supervisor-approve']);
            Route::post('supervisor-reject', [PackageTimelineController::class, 'supervisorReject'])->middleware(['permissions:package-timeline-supervisor-reject']);
            Route::post('submit-for-supervisor', [PackageTimelineController::class, 'readyToSupervisorApproval'])->middleware(['permissions:package-timeline-ready-to-supervisor-approval']);
            Route::post('submit-for-document-verify', [PackageTimelineController::class, 'submitForVerifyDocuments'])->middleware(['permissions:package-timeline-verify-documents']);
            Route::post('document-approve', [PackageTimelineController::class, 'verifyDocuments'])->middleware(['permissions:package-timeline-verify-documents']);
            Route::post('document-reject', [PackageTimelineController::class, 'rejectDocuments'])->middleware(['permissions:package-timeline-reject-documents']);
            Route::post('print', [PackageTimelineController::class, 'agreementPrint'])->middleware(['permissions:package-timeline-print']);
            Route::post('ready-to-sign', [PackageTimelineController::class, 'readyToSign'])->middleware(['permissions:package-timeline-ready-to-sign']);
            Route::post('signed', [PackageTimelineController::class, 'markSigned'])->middleware(['permissions:package-timeline-signed']);
            Route::post('started', [PackageTimelineController::class, 'markStarted'])->middleware(['permissions:package-timeline-started']);
            Route::post('mark-matured', [PackageTimelineController::class, 'markMatured'])->middleware(['permissions:package-timeline-mark-matured']);
            Route::post('cancel', [PackageTimelineController::class, 'cancelPackage'])->middleware(['permissions:package-timeline-cancel']);
            Route::get('by-package/{package_id}', [PackageTimelineController::class, 'getByPackageId'])->middleware(['permissions:package-timeline-by-package']);
        });

        Route::prefix('payments')->group(function () {
            Route::get('by-package/{package_id}', [PaymentController::class, 'getByPackageId'])->middleware(['permissions:payments-view-by-package']);
            Route::get('{id}/file', [PaymentController::class, 'getPDF'])->middleware(['permissions:payments-get-file']);
            Route::get('', [PaymentController::class, 'getAll'])->middleware(['permissions:payments-view-all']);
            Route::post('', [PaymentController::class, 'add'])->middleware(['permissions:payments-add']);
        });

        Route::prefix('benefits')->group(function () {
            Route::get('', [BenefitController::class, 'getAll'])->middleware(['permissions:benefits-view-all']);
            Route::post('pay', [BenefitController::class, 'markPayment'])->middleware(['permissions:benefits-mark-payment']);
        });

        Route::prefix('package-media')->group(function () {
            Route::post('', [PackageMediaController::class, 'updateOrCreate'])->middleware(['permissions:package-media-update-or-create']);
            Route::delete('{id}', [PackageMediaController::class, 'destroy'])->middleware(['permissions:package-media-delete']);
            Route::get('by-package/{package_id}', [PackageMediaController::class, 'getByPackageId'])->middleware(['permissions:package-media-by-package']);
        });

        Route::prefix('user-packages')->group(function () {
            Route::get('agent', [UserPackageController::class, 'getAgentProposals'])->middleware(['permissions:user-packages-agent-proposals']);
            Route::get('supervisor', [UserPackageController::class, 'getSupervisorProposals'])->middleware(['permissions:user-packages-supervisor-proposals']);
            Route::get('payment-pending', [UserPackageController::class, 'getPaymentPending'])->middleware(['permissions:user-packages-payment-pending']);

            Route::get('paginate', [UserPackageController::class, 'getPaginate'])->middleware(['permissions:user-packages-view-all']);
            Route::delete('{id}', [UserPackageController::class, 'delete'])->middleware(['permissions:user-packages-delete']);
            Route::get('{id}', [UserPackageController::class, 'getById'])->middleware(['permissions:user-packages-view']);
            Route::get('', [UserPackageController::class, 'getAll'])->middleware(['permissions:user-packages-view-all']);
            Route::post('', [UserPackageController::class, 'add'])->middleware(['permissions:user-packages-add']);
            Route::put('{id}', [UserPackageController::class, 'update'])->middleware(['permissions:user-packages-update']);
        });

        Route::prefix('media')->group(function () {
            Route::post('upload', [MediaController::class, 'upload'])->middleware(['permissions:media-upload']);
        });
    });
});
