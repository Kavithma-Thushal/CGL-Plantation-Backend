<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use App\Classes\ErrorResponse;
use Illuminate\Support\Facades\App;
use App\Http\Resources\SuccessResource;
use App\Http\Services\UserPackageService;
use App\Http\Requests\GetTimelineByPackage;
use App\Http\Requests\PackageCancelRequest;
use App\Http\Requests\ProposalDocumentRejectRequest;
use App\Http\Requests\ProposalPrintRequest;
use App\Http\Services\PackageTimelineService;
use App\Http\Requests\SupervisorRejectRequest;
use App\Http\Requests\ProposalMarkStartRequest;
use App\Http\Requests\SupervisorApproveRequest;
use App\Http\Resources\PackageTimelineResource;
use App\Http\Requests\ProposalMarkSignedRequest;
use App\Http\Requests\ProposalMarkMaturedRequest;
use App\Http\Requests\ProposalReadyToSignRequest;
use App\Http\Requests\ProposalDocumentVerifyRequest;
use App\Http\Requests\SubmitForDocumentVerifyRequest;
use App\Http\Requests\SubmitForSupervisorRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ZipArchive;

class PackageTimelineController extends Controller
{
    public function __construct(
        private UserPackageService $userPackageService,
        private PackageTimelineService $packageTimelineService)
    {
    }

    public function supervisorApprove(SupervisorApproveRequest $request)
    {
        try {
            $this->packageTimelineService->supervisorApprove($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Proposal Approved']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function supervisorReject(SupervisorRejectRequest $request)
    {
        try {
            $this->packageTimelineService->supervisorReject($request['proposal_id'],$request['reason']);
            return new SuccessResource(['data' => ['message' => 'Proposal Rejected']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function readyToSupervisorApproval(SubmitForSupervisorRequest $request)
    {
        try {
            $this->packageTimelineService->readyToSupervisorApproval($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Submitted for Supervisor Approval']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function submitForVerifyDocuments(SubmitForDocumentVerifyRequest $request)
    {
        try {
            $this->packageTimelineService->readyToDocumentVerify($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Submitted for Document Verification']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function verifyDocuments(ProposalDocumentVerifyRequest $request)
    {
        try {
            $this->packageTimelineService->verifyDocuments($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Document Verified']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function rejectDocuments(ProposalDocumentRejectRequest $request)
    {
        try {
            $this->packageTimelineService->rejectDocuments($request['proposal_id'],$request['reason']);
            return new SuccessResource(['data' => ['message' => 'Proposal Rejected']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function agreementPrint(ProposalPrintRequest $request)
    {
        try {
            $proposal = $this->userPackageService->getFullDetail($request->proposal_id);
            $this->packageTimelineService->agreementPrint($request['proposal_id']);

            // Agreement.pdf
            $agreement = App::make(PDF::class);
            $agreement->loadView($proposal['lang'] === 'en' ? 'pdf.agreement-english' : 'pdf.agreement-sinhala', ['proposal'=>$proposal]);
            $agreementContent = $agreement->output();

            //Elegance-Plan.pdf
            $elegancePlan = App::make(PDF::class);
            $elegancePlan->loadView('pdf.agreement-elegance-plan', ['proposal' => $proposal]);
            $elegancePlanContent = $elegancePlan->output();

            // Create zip
            $zipFile = storage_path('app/agreement_files.zip');
            $zip = new ZipArchive;
            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                $zip->addFromString('agreement.pdf', $agreementContent);
                $zip->addFromString('elegance_plan.pdf', $elegancePlanContent);
                $zip->close();
            }

            // Return zip
            return response()->download($zipFile)->deleteFileAfterSend(true);

        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function readyToSign(ProposalReadyToSignRequest $request)
    {
        try {
            $this->packageTimelineService->readyToSign($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Agreement Ready To Sign']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function markSigned(ProposalMarkSignedRequest $request)
    {
        try {
            $this->packageTimelineService->markSigned($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Agreement Signed']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function markStarted(ProposalMarkStartRequest $request)
    {
        try {
            $this->packageTimelineService->markStarted($request['proposal_id']);
            return new SuccessResource(['data' => ['message' => 'Package Stated']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function markMatured(ProposalMarkMaturedRequest $request)
    {
        try {
            $this->packageTimelineService->matured($request->validated());
            return new SuccessResource(['data' => ['message' => 'Package Matured']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function cancelPackage(PackageCancelRequest $request)
    {
        try {
            $this->packageTimelineService->cancel($request->validated());
            return new SuccessResource(['data' => ['message' => 'Package cancelled']]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }

    public function getByPackageId($packageId,GetTimelineByPackage $request)
    {
        try {
            $data = $this->packageTimelineService->getByPackageId($packageId);
            return new SuccessResource(['data' => PackageTimelineResource::collection($data)]);
        } catch (HttpException $e) {
            ErrorResponse::throwException($e);
        }
    }
}
