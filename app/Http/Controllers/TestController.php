<?php

namespace App\Http\Controllers;

use App\Enums\PackageStatusesEnum;
use App\Http\Requests\ProposalCreateRequest;
use Illuminate\Http\Request;
use App\Http\Resources\SuccessResource;
use App\Http\Services\BenefitService;
use App\Http\Services\PackageTimelineService;
use App\Http\Services\QuotationRequestService;
use App\Http\Services\UserPackageService;
use App\Models\UserPackage;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Example",
 *     description="API Endpoints of swagger examples"
 * )
 */
class TestController extends Controller
{

    public function index(){
        return "CGLP is working";
    }

    public function testPDF($id)
    {
        $quotationRequestService = App::make(QuotationRequestService::class);
        $quotationRequest = $quotationRequestService->getFullDetail($id);
        $pdf = App::make(PDF::class);
        $pdf->loadView('pdf.quotation-request', ['quotationRequest' => $quotationRequest]);
        return $pdf->download('quotation.pdf');
    }
   
    public function testSchedule($id)
    {
        $userPackageService = App::make(UserPackageService::class);
        $userPackage = $userPackageService->getFullDetail($id);
        if($userPackage == null) return 'not found';
        $pdf = App::make(PDF::class);
        $pdf->loadView('pdf.schedule', ['userPackage' => $userPackage]);
        return $pdf->download('schedule.pdf');
    }

    public function packageTimeline(int $packageId){
        $benefitService = App::make(PackageTimelineService::class);
        $benefitService->supervisorApprove($packageId);
        $benefitService->verifyDocuments($packageId);
        $benefitService->verifyDocuments($packageId);
        $benefitService->agreementPrint($packageId);
        $benefitService->readyToSign($packageId);
        $benefitService->markSigned($packageId);
        $benefitService->markStarted($packageId);
        $package =  UserPackage::with(['packageTimeline'])->find($packageId);
        return ['current_status'=>$package->getActiveTimeline(),'package'=>$package];
    }
  
    public function startAllPackages(){
        $packages = UserPackage::whereDoesntHave('packageTimeline.packageStatus', function ($q) {
            $q->where('name', PackageStatusesEnum::STARTED);
        })->get();
        foreach($packages as $package){
            $this->packageTimeline($package->id);
        }
        return $packages->pluck('id');
    }
   
    public function createMultiplePackages(ProposalCreateRequest $request){
        $ids = [];
        $userPackageService = App::make(UserPackageService::class);
        for($i = 0;$i < 8;$i++){
            $data =  $userPackageService->add($request->validated());
            array_push($ids,$data['id']);
        }
        return $ids;
    }

    public function authUser(){
        return Auth::user();
    }
    /**
     * @OA\Get(
     *     path="/api/test/swagger-examples/{id}",
     *     tags={"Example"},
     *     summary="Example request for get by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="age", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="error", type="string"),
     *                 @OA\Property(property="key", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="404", description="Not found")
     * )
     */
    public function getById(Request $request)
    {
        return new SuccessResource([
            'id' => 1,
            'name' => 'John Doe',
            'age' => 28,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/test/swagger-examples/{id}",
     *     tags={"Example"},
     *     summary="Example request for delete",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="404", description="Not found")
     * )
     */
    public function delete(Request $request)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/test/swagger-examples",
     *     tags={"Example"},
     *     summary="Example request for get all",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     * )
     */
    public function getAll(Request $request)
    {

    }

    /**
     * @OA\Patch(
     *     path="/api/test/swagger-examples/{id}",
     *     tags={"Example"},
     *     summary="Example request for update",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id",
     *         required=true,
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="age",
     *         in="query",
     *         description="Age",
     *         @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Validation failed")
     * )
     */
    public function update(Request $request)
    {

    }

    /**
     * @OA\Post(
     *     path="/api/test/swagger-examples",
     *     tags={"Example"},
     *     summary="Example request for save",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="age", type="integer")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Validation failed")
     * )
     */
    public function save(Request $request)
    {

    }

}
