<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Plan\PlanRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Media\MediaRepository;
use App\Repositories\Title\TitleRepository;
use App\Repositories\Branch\BranchRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\Plan\PlanRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Quotation\QuotationRepository;
use App\Repositories\Media\MediaRepositoryInterface;
use App\Repositories\Title\TitleRepositoryInterface;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\BankAccount\BankAccountRepository;
use App\Repositories\Designation\DesignationRepository;
use App\Repositories\UserPackage\UserPackageRepository;
use App\Repositories\PlanTemplate\PlanTemplateRepository;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\PackageStatus\PackageStatusRepository;
use App\Repositories\Quotation\QuotationRepositoryInterface;
use App\Repositories\EmployeeBranch\EmployeeBranchRepository;
use App\Repositories\PackageTimeline\PackageTimelineRepository;
use App\Repositories\PersonalDetails\PersonalDetailsRepository;
use App\Repositories\PlanBenefitRate\PlanBenefitRateRepository;
use App\Repositories\BankAccount\BankAccountRepositoryInterface;
use App\Repositories\Designation\DesignationRepositoryInterface;
use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Repositories\QuotationRequest\QuotationRequestRepository;
use App\Repositories\PlanTemplate\PlanTemplateRepositoryInterface;
use App\Repositories\PackageStatus\PackageStatusRepositoryInterface;
use App\Repositories\EmployeeBankDetail\EmployeeBankDetailRepository;
use App\Repositories\EmployeeBranch\EmployeeBranchRepositoryInterface;
use App\Repositories\AdministrativeLevel\AdministrativeLevelRepository;
use App\Repositories\EmployeeDesignation\EmployeeDesignationRepository;
use App\Repositories\PackageTimeline\PackageTimelineRepositoryInterface;
use App\Repositories\PersonalDetails\PersonalDetailsRepositoryInterface;
use App\Repositories\PlanBenefitRate\PlanBenefitRateRepositoryInterface;
use App\Repositories\QuotationRequest\QuotationRequestRepositoryInterface;
use App\Repositories\EmployeeBankDetail\EmployeeBankDetailRepositoryInterface;
use App\Repositories\AdministrativeHierarchy\AdministrativeHierarchyRepository;
use App\Repositories\AdministrativeLevel\AdministrativeLevelRepositoryInterface;
use App\Repositories\EmployeeDesignation\EmployeeDesignationRepositoryInterface;
use App\Repositories\AdministrativeHierarchy\AdministrativeHierarchyRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquent();
    }

    private function registerEloquent()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DesignationRepositoryInterface::class, DesignationRepository::class);
        $this->app->bind(AdministrativeLevelRepositoryInterface::class, AdministrativeLevelRepository::class);
        $this->app->bind(AdministrativeHierarchyRepositoryInterface::class, AdministrativeHierarchyRepository::class);
        $this->app->bind(PlanTemplateRepositoryInterface::class, PlanTemplateRepository::class);
        $this->app->bind(PlanBenefitRateRepositoryInterface::class, PlanBenefitRateRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(TitleRepositoryInterface::class, TitleRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(PersonalDetailsRepositoryInterface::class, PersonalDetailsRepository::class);
        $this->app->bind(BankAccountRepositoryInterface::class, BankAccountRepository::class);
        $this->app->bind(EmployeeBankDetailRepositoryInterface::class, EmployeeBankDetailRepository::class);
        $this->app->bind(EmployeeDesignationRepositoryInterface::class, EmployeeDesignationRepository::class);
        $this->app->bind(EmployeeBranchRepositoryInterface::class, EmployeeBranchRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(MediaRepositoryInterface::class, MediaRepository::class);
        $this->app->bind(QuotationRepositoryInterface::class, QuotationRepository::class);
        $this->app->bind(QuotationRequestRepositoryInterface::class, QuotationRequestRepository::class);
        $this->app->bind(UserPackageRepositoryInterface::class, UserPackageRepository::class);
        $this->app->bind(\App\Repositories\ApprovalRequest\ApprovalRequestRepositoryInterface::class, \App\Repositories\ApprovalRequest\ApprovalRequestRepository::class);
        $this->app->bind(PackageStatusRepositoryInterface::class, PackageStatusRepository::class);
        $this->app->bind(\App\Repositories\PackageMedia\PackageMediaRepositoryInterface::class, \App\Repositories\PackageMedia\PackageMediaRepository::class);
        $this->app->bind(PackageTimelineRepositoryInterface::class, PackageTimelineRepository::class);
        $this->app->bind(\App\Repositories\Receipt\ReceiptRepositoryInterface::class, \App\Repositories\Receipt\ReceiptRepository::class);
        $this->app->bind(\App\Repositories\PackageCustomerDetail\PackageCustomerDetailRepositoryInterface::class, \App\Repositories\PackageCustomerDetail\PackageCustomerDetailRepository::class);
        $this->app->bind(\App\Repositories\Customer\CustomerRepositoryInterface::class, \App\Repositories\Customer\CustomerRepository::class);
        $this->app->bind(\App\Repositories\Beneficiary\BeneficiaryRepositoryInterface::class, \App\Repositories\Beneficiary\BeneficiaryRepository::class);
        $this->app->bind(\App\Repositories\Nominee\NomineeRepositoryInterface::class, \App\Repositories\Nominee\NomineeRepository::class);
        $this->app->bind(\App\Repositories\Introducer\IntroducerRepositoryInterface::class, \App\Repositories\Introducer\IntroducerRepository::class);
        $this->app->bind(\App\Repositories\Race\RaceRepositoryInterface::class, \App\Repositories\Race\RaceRepository::class);
        $this->app->bind(\App\Repositories\Nationality\NationalityRepositoryInterface::class, \App\Repositories\Nationality\NationalityRepository::class);
        $this->app->bind(\App\Repositories\Country\CountryRepositoryInterface::class, \App\Repositories\Country\CountryRepository::class);
        $this->app->bind(\App\Repositories\TreeBrand\TreeBrandRepositoryInterface::class, \App\Repositories\TreeBrand\TreeBrandRepository::class);
        $this->app->bind(\App\Repositories\Occupation\OccupationRepositoryInterface::class, \App\Repositories\Occupation\OccupationRepository::class);
        $this->app->bind(\App\Repositories\Benefit\BenefitRepositoryInterface::class, \App\Repositories\Benefit\BenefitRepository::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
