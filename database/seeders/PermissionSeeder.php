<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Role::truncate();
        Permission::truncate();
        $employeeGuard = 'web';

        /* ---- PERMISSIONS ---- */

        /* customers */
        $customerViewAll = Permission::firstOrCreate(['name' => 'customers-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Customers']);
        $customerUpdate = Permission::firstOrCreate(['name' => 'customers-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Customer']);
        $customers = [$customerViewAll,$customerUpdate];

        /* designations */
        $designationCreate = Permission::firstOrCreate(['name' => 'designations-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Designation']);
        $designationUpdate = Permission::firstOrCreate(['name' => 'designations-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Designation']);
        $designationDelete = Permission::firstOrCreate(['name' => 'designations-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Designation']);
        $designationView = Permission::firstOrCreate(['name' => 'designations-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Designation']);
        $designationViewAll = Permission::firstOrCreate(['name' => 'designations-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Designations']);
        $designationTree = Permission::firstOrCreate(['name' => 'designations-tree', 'guard_name' => $employeeGuard, 'display_name' => 'View Designation Tree']);
        $designationPage = Permission::firstOrCreate(['name' => 'designations-page', 'guard_name' => $employeeGuard, 'display_name' => 'View Designation Page']);
        $designations = [$designationCreate, $designationPage, $designationUpdate, $designationDelete, $designationView, $designationViewAll, $designationTree];

        /* plans */
        $planCreate = Permission::firstOrCreate(['name' => 'plans-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Plan']);
        $planUpdate = Permission::firstOrCreate(['name' => 'plans-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Plan']);
        $planDelete = Permission::firstOrCreate(['name' => 'plans-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Plan']);
        $planView = Permission::firstOrCreate(['name' => 'plans-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Plan']);
        $planViewAll = Permission::firstOrCreate(['name' => 'plans-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Plans']);
        $plans = [$planCreate, $planUpdate, $planDelete, $planView, $planViewAll];

        /* admin levels */
        $adminLevelCreate = Permission::firstOrCreate(['name' => 'administrative-levels-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Administrative Level']);
        $adminLevelUpdate = Permission::firstOrCreate(['name' => 'administrative-levels-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Administrative Level']);
        $adminLevelDelete = Permission::firstOrCreate(['name' => 'administrative-levels-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Administrative Level']);
        $adminLevelView = Permission::firstOrCreate(['name' => 'administrative-levels-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Administrative Level']);
        $adminLevelViewAll = Permission::firstOrCreate(['name' => 'administrative-levels-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Administrative Levels']);
        $adminLevels = [$adminLevelCreate, $adminLevelUpdate, $adminLevelDelete, $adminLevelView, $adminLevelViewAll];

        /* admin hierarchy */
        $adminHierarchyCreate = Permission::firstOrCreate(['name' => 'administrative-hierarchies-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Administrative Hierarchy']);
        $adminHierarchyUpdate = Permission::firstOrCreate(['name' => 'administrative-hierarchies-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Administrative Hierarchy']);
        $adminHierarchyDelete = Permission::firstOrCreate(['name' => 'administrative-hierarchies-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Administrative Hierarchy']);
        $adminHierarchyView = Permission::firstOrCreate(['name' => 'administrative-hierarchies-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Administrative Hierarchy']);
        $adminHierarchyViewAll = Permission::firstOrCreate(['name' => 'administrative-hierarchies-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Administrative Hierarchies']);
        $adminHierarchies = [$adminHierarchyCreate, $adminHierarchyUpdate, $adminHierarchyDelete, $adminHierarchyView, $adminHierarchyViewAll];

        /* plan templates */
        $planTemplateView = Permission::firstOrCreate(['name' => 'plan-templates-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Plan Template']);
        $planTemplateViewAll = Permission::firstOrCreate(['name' => 'plan-templates-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Plan Templates']);
        $planTemplates = [$planTemplateView, $planTemplateViewAll];

        /* employees */
        $employeeCreate = Permission::firstOrCreate(['name' => 'employees-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Employee']);
        $employeeUpdate = Permission::firstOrCreate(['name' => 'employees-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Employee']);
        $employeeDelete = Permission::firstOrCreate(['name' => 'employees-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Employee']);
        $employeeView = Permission::firstOrCreate(['name' => 'employees-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Employee']);
        $employeeViewAll = Permission::firstOrCreate(['name' => 'employees-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Employees']);
        $employeeByNIC = Permission::firstOrCreate(['name' => 'employees-view-by-nic', 'guard_name' => $employeeGuard, 'display_name' => 'View Employee by NIC']);
        $employees = [$employeeCreate, $employeeUpdate, $employeeDelete, $employeeView, $employeeViewAll, $employeeByNIC];

        /* quotation */
        $quotationCreate = Permission::firstOrCreate(['name' => 'quotations-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Quotation']);
        $quotationUpdate = Permission::firstOrCreate(['name' => 'quotations-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Quotation']);
        $quotationView = Permission::firstOrCreate(['name' => 'quotations-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Quotation']);
        $quotationViewAll = Permission::firstOrCreate(['name' => 'quotations-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Quotations']);
        $quotationGetPDF = Permission::firstOrCreate(['name' => 'quotations-get-pdf', 'guard_name' => $employeeGuard, 'display_name' => 'Get Quotation PDF']);
        $quotations = [$quotationCreate, $quotationUpdate, $quotationView, $quotationViewAll, $quotationGetPDF];

        /* quotation request */
        $quotationRequestView = Permission::firstOrCreate(['name' => 'quotation-requests-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Quotation Request']);
        $quotationRequestViewAll = Permission::firstOrCreate(['name' => 'quotation-requests-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Quotation Requests']);
        $quotationRequestGetPDF = Permission::firstOrCreate(['name' => 'quotations-request-get-pdf', 'guard_name' => $employeeGuard, 'display_name' => 'Get Quotation Request PDF']);
        $quotationRequests = [$quotationRequestView, $quotationRequestViewAll, $quotationRequestGetPDF];

        /* package timeline */
        $packageTimelineUpdate = Permission::firstOrCreate(['name' => 'package-timeline-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update Package Timeline']);
        $packageTimelineSupervisorApprove = Permission::firstOrCreate(['name' => 'package-timeline-supervisor-approve', 'guard_name' => $employeeGuard, 'display_name' => 'Supervisor Approve Package Timeline']);
        $packageTimelineSupervisorReject = Permission::firstOrCreate(['name' => 'package-timeline-supervisor-reject', 'guard_name' => $employeeGuard, 'display_name' => 'Supervisor Reject Package Timeline']);
        $packageTimelineReadyToSupervisorApproval = Permission::firstOrCreate(['name' => 'package-timeline-ready-to-supervisor-approval', 'guard_name' => $employeeGuard, 'display_name' => 'Ready for Supervisor Approval']);
        $packageTimelineVerifyDocuments = Permission::firstOrCreate(['name' => 'package-timeline-verify-documents', 'guard_name' => $employeeGuard, 'display_name' => 'Verify Documents']);
        $packageTimelineRejectDocuments = Permission::firstOrCreate(['name' => 'package-timeline-reject-documents', 'guard_name' => $employeeGuard, 'display_name' => 'Reject Documents']);
        $packageTimelinePrint = Permission::firstOrCreate(['name' => 'package-timeline-print', 'guard_name' => $employeeGuard, 'display_name' => 'Print Agreement']);
        $packageTimelineReadyToSign = Permission::firstOrCreate(['name' => 'package-timeline-ready-to-sign', 'guard_name' => $employeeGuard, 'display_name' => 'Ready to Sign']);
        $packageTimelineSigned = Permission::firstOrCreate(['name' => 'package-timeline-signed', 'guard_name' => $employeeGuard, 'display_name' => 'Mark as Signed']);
        $packageTimelineStarted = Permission::firstOrCreate(['name' => 'package-timeline-started', 'guard_name' => $employeeGuard, 'display_name' => 'Mark as Started']);
        $packageTimelineMarkMatured = Permission::firstOrCreate(['name' => 'package-timeline-mark-matured', 'guard_name' => $employeeGuard, 'display_name' => 'Mark as Matured']);
        $packageTimelineCancel = Permission::firstOrCreate(['name' => 'package-timeline-cancel', 'guard_name' => $employeeGuard, 'display_name' => 'Cancel Package']);
        $packageTimelineByPackage = Permission::firstOrCreate(['name' => 'package-timeline-by-package', 'guard_name' => $employeeGuard, 'display_name' => 'Get Package Timeline by Package ID']);
        $packageTimelines = [$packageTimelineUpdate, $packageTimelineSupervisorApprove, $packageTimelineSupervisorReject, $packageTimelineReadyToSupervisorApproval, $packageTimelineVerifyDocuments, $packageTimelineRejectDocuments, $packageTimelinePrint, $packageTimelineReadyToSign, $packageTimelineSigned, $packageTimelineStarted, $packageTimelineMarkMatured, $packageTimelineCancel, $packageTimelineByPackage];

        /* payments */
        $paymentViewByPackage = Permission::firstOrCreate(['name' => 'payments-view-by-package', 'guard_name' => $employeeGuard, 'display_name' => 'View Payments by Package']);
        $paymentViewAll = Permission::firstOrCreate(['name' => 'payments-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Payments']);
        $paymentCreate = Permission::firstOrCreate(['name' => 'payments-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add Payment']);
        $paymentGetPDF = Permission::firstOrCreate(['name' => 'payments-get-file', 'guard_name' => $employeeGuard, 'display_name' => 'Payment Get PDF']);
        $payments = [$paymentViewByPackage, $paymentViewAll, $paymentCreate, $paymentGetPDF];

        /* user packages */
        $userPackageAgentProposals = Permission::firstOrCreate(['name' => 'user-packages-agent-proposals', 'guard_name' => $employeeGuard, 'display_name' => 'View Agent Proposals']);
        $userPackageSupervisorProposals = Permission::firstOrCreate(['name' => 'user-packages-supervisor-proposals', 'guard_name' => $employeeGuard, 'display_name' => 'View Supervisor Proposals']);
        $userPackagePaymentPending = Permission::firstOrCreate(['name' => 'user-packages-payment-pending', 'guard_name' => $employeeGuard, 'display_name' => 'View Payment Pending']);
        $userPackageView = Permission::firstOrCreate(['name' => 'user-packages-view', 'guard_name' => $employeeGuard, 'display_name' => 'View User Package']);
        $userPackageViewAll = Permission::firstOrCreate(['name' => 'user-packages-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All User Packages']);
        $userPackageCreate = Permission::firstOrCreate(['name' => 'user-packages-add', 'guard_name' => $employeeGuard, 'display_name' => 'Add User Package']);
        $userPackageUpdate = Permission::firstOrCreate(['name' => 'user-packages-update', 'guard_name' => $employeeGuard, 'display_name' => 'Update User Package']);
        $userPackageDelete = Permission::firstOrCreate(['name' => 'user-packages-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete User Package']);
        $userPackages = [$userPackageAgentProposals, $userPackageSupervisorProposals, $userPackagePaymentPending, $userPackageView, $userPackageViewAll, $userPackageCreate, $userPackageUpdate, $userPackageDelete];

        /* package media */
        $packageMediaUpdateOrCreate = Permission::firstOrCreate(['name' => 'package-media-update-or-create', 'guard_name' => $employeeGuard, 'display_name' => 'Update or Create Package Media']);
        $packageMediaDelete = Permission::firstOrCreate(['name' => 'package-media-delete', 'guard_name' => $employeeGuard, 'display_name' => 'Delete Package Media']);
        $packageMediaByPackage = Permission::firstOrCreate(['name' => 'package-media-by-package', 'guard_name' => $employeeGuard, 'display_name' => 'Get Package Media by Package ID']);
        $packageMediaPermissions = [$packageMediaUpdateOrCreate, $packageMediaDelete, $packageMediaByPackage];

        /* maser data */
        $titleView = Permission::firstOrCreate(['name' => 'master-data-titles-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Titles']);
        $bankView = Permission::firstOrCreate(['name' => 'master-data-banks-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Banks']);
        $branchView = Permission::firstOrCreate(['name' => 'master-data-branches-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Branches']);
        $roleView = Permission::firstOrCreate(['name' => 'master-data-roles-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Roles']);
        $raceView = Permission::firstOrCreate(['name' => 'master-data-races-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Races']);
        $nationalityView = Permission::firstOrCreate(['name' => 'master-data-nationalities-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Nationalities']);
        $occupationView = Permission::firstOrCreate(['name' => 'master-data-occupations-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Occupations']);
        $countryView = Permission::firstOrCreate(['name' => 'master-data-countries-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Countries']);
        $treeBrandView = Permission::firstOrCreate(['name' => 'master-data-tree-brands-view', 'guard_name' => $employeeGuard, 'display_name' => 'View Tree Brands']);
        $masterDataPermissions = [$titleView, $bankView, $branchView, $roleView, $raceView, $nationalityView, $occupationView, $countryView, $treeBrandView];

        /* benefits */
        $benefitByPackage = Permission::firstOrCreate(['name' => 'benefits-by-package', 'guard_name' => $employeeGuard, 'display_name' => 'View Benefits by Package']);
        $benefitViewAll = Permission::firstOrCreate(['name' => 'benefits-view-all', 'guard_name' => $employeeGuard, 'display_name' => 'View All Benefits']);
        $benefitMarkPayment = Permission::firstOrCreate(['name' => 'benefits-mark-payment', 'guard_name' => $employeeGuard, 'display_name' => 'Mark Benefit Payment']);
        $benefitPermissions = [$benefitByPackage, $benefitViewAll, $benefitMarkPayment];

        /* media */
        $mediaUpload = Permission::firstOrCreate(['name' => 'media-upload', 'guard_name' => $employeeGuard, 'display_name' => 'Upload Media']);
        $mediaPermissions = [$mediaUpload];

        $allPermissions = [$designations, $plans, $adminLevels, $adminHierarchies, $planTemplates, $employees, $quotations, $quotationRequests, $packageTimelines, $payments, $userPackages, $packageMediaPermissions, $masterDataPermissions, $benefitPermissions, $mediaPermissions];

        $chairmanPermissions = [$designations, $customers, $plans, $adminLevels, $adminHierarchies, $planTemplates, $employees, $quotations, $quotationRequests, $packageTimelines, $payments, $userPackages, $packageMediaPermissions, $masterDataPermissions, $benefitPermissions, $mediaPermissions];

        /* ---- ROLES ---- */
        $superAdmin = Role::firstOrCreate(['name' => 'System Admin', 'status' => 0]);
        $superAdmin->syncPermissions([$employees, $designationViewAll, $masterDataPermissions,$mediaPermissions]);

        $chairman = Role::firstOrCreate(['name' => 'Administrator']);
        $chairman->syncPermissions($chairmanPermissions);

        $branchManager = Role::firstOrCreate(['name' => 'Branch Manager']);
        $branchManager->syncPermissions($allPermissions);

        $branchManager = Role::firstOrCreate(['name' => 'Data Entry']);
        $branchManager->syncPermissions($allPermissions);

        Schema::enableForeignKeyConstraints();
    }
}
