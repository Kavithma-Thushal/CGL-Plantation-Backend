<?php

namespace App\Http\Services;

use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\Race\RaceRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Title\TitleRepositoryInterface;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\Nationality\NationalityRepositoryInterface;
use App\Repositories\Occupation\OccupationRepositoryInterface;
use App\Repositories\TreeBrand\TreeBrandRepositoryInterface;

class MasterDataService
{
    public function __construct(
        private TitleRepositoryInterface $titleRepositoryInterface,
        private BranchRepositoryInterface $branchRepositoryInterface,
        private RoleRepositoryInterface $roleRepositoryInterface,
        private BankRepositoryInterface $bankRepositoryInterface,
        private RaceRepositoryInterface $raceRepositoryInterface,
        private NationalityRepositoryInterface $nationalityRepositoryInterface,
        private CountryRepositoryInterface $countryRepositoryInterface,
        private TreeBrandRepositoryInterface $treeBrandRepositoryInterface,
        private OccupationRepositoryInterface $occupationRepositoryInterface
    ) {
    }

    public function getTitles($filters = [])
    {
        return $this->titleRepositoryInterface->getAll($filters);
    }

    public function getBanks($filters = [])
    {
        return $this->bankRepositoryInterface->getAll($filters);
    }

    public function getBranches($filters = [])
    {
        return $this->branchRepositoryInterface->getAll($filters);
    }

    public function getRoles($filters = [])
    {
        return $this->roleRepositoryInterface->getAll($filters);
    }

    public function getRaces($filters = [])
    {
        return $this->raceRepositoryInterface->getAll($filters);
    }

    public function getNationalities($filters = [])
    {
        return $this->nationalityRepositoryInterface->getAll($filters);
    }

    public function getCountries($filters = [])
    {
        return $this->countryRepositoryInterface->getAll($filters);
    }
 
    public function getOccupations($filters = [])
    {
        return $this->occupationRepositoryInterface->getAll($filters);
    }
    
    public function getTreeBrands($filters = [])
    {
        return $this->treeBrandRepositoryInterface->getAll($filters);
    }
}
