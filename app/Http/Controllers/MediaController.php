<?php

namespace App\Http\Controllers;

use App\Classes\ErrorResponse;
use App\Http\Services\MediaService;
use App\Http\Resources\MediaResource;
use App\Http\Requests\MediaAddRequest;
use App\Http\Resources\SuccessResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MediaController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function upload(MediaAddRequest $request)
    {
        try {
            $data = $this->mediaService->upload($request);
            return new SuccessResource([
                'message' => 'File uploaded',
                'data' => new MediaResource($data)
            ]);
        } catch (HttpException $e) {
            ErrorResponse::rollback($e);
        }
    }
}
