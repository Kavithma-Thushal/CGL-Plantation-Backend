<?php

namespace App\Http\Services;

use App\Mail\PaymentReceiptMail;
use App\Models\Receipt;
use App\Repositories\Receipt\ReceiptRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReceiptService
{
    public function __construct(
        private ReceiptRepositoryInterface $receiptRepositoryInterface,
    ) {
    }

    public function find(int $id){
        return $this->receiptRepositoryInterface->find($id);
    }

    public function getAll(array $data){
        return $this->receiptRepositoryInterface->getAll($data);
    }

    public function getByPackageId(int $packageId){
        $data['user_package_id'] = $packageId;
        return $this->receiptRepositoryInterface->getAll($data);
    }

    public function add(array $data)
    {
        $receiptData = [
            'user_package_id' => $data['user_package_id'],
            'payment_method' => $data['payment_method'],
            'ref_number_index' => Receipt::getNextNumber()['index'],
            'receipt_number' => Receipt::getNextNumber()['number'],
            'ref_number' => $data['reference'],
            'amount' => $data['amount'],
            'payment_date' => $data['payment_date'],
            'is_email' => $data['send_receipt'] ?? 0,
            'is_download' => $data['download_receipt'] ?? 0
        ];

        $receipt = $this->receiptRepositoryInterface->add($receiptData);

        if ($data['send_receipt']) {
            $userPackage = $receipt->userPackage;
            $customer = $userPackage->packageCustomerDetail->customer;
            $customerEmail = $userPackage->packageCustomerDetail->email;
            if (!empty($customerEmail)) {
                Mail::to($customerEmail)->queue(new PaymentReceiptMail($userPackage, $customer));
            }
        }

        return $receipt;
    }
}
