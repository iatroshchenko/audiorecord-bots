<?php


namespace App\Traits\Controller;


use Illuminate\Http\JsonResponse;

trait SendsEmptyResponse
{
    public function sendDataResponse($data): JsonResponse
    {
        return response()
            ->json([
                'data' => $data
            ]);
    }

    public function sendEmptyResponse(): JsonResponse
    {
        return response()
            ->json([]);
    }

    public function sendEmptyTrueResponse(string $resultDescription): JsonResponse
    {
        return response()->json([
            $resultDescription => true
        ]);
    }

    public function sendCreatedResponse(): JsonResponse
    {
        return $this->sendEmptyTrueResponse('created');
    }

    public function sendUpdatedResponse(): JsonResponse
    {
        return $this->sendEmptyTrueResponse('updated');
    }

    public function sendDeletedResponse(): JsonResponse
    {
        return $this->sendEmptyTrueResponse('deleted');
    }

    public function sendSentResponse(): JsonResponse
    {
        return $this->sendEmptyTrueResponse('sent');
    }
}
