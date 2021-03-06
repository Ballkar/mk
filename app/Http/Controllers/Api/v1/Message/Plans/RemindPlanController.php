<?php

namespace App\Http\Controllers\Api\v1\Message\Plans;

use App\Http\Controllers\ApiCommunication;
use App\Http\Requests\Message\Plans\RemindPlanPreviewRequest;
use App\Http\Requests\Message\Plans\RemindPlanRequest;
use App\Http\Resources\Message\Plans\RemindPlan as RemindPlanResource;
use App\Models\Announcement\Customer;
use App\Models\User\User;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Instasent\SMSCounter\SMSCounter;

class RemindPlanController extends Controller
{
    use ApiCommunication;

    public function __construct()
    { }

    /**
     * @return JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        $plan = $user->remindPlan;
        return $this->sendResponse(new RemindPlanResource($plan), 'Plan returned');
    }

    /**
     * @param RemindPlanRequest $request
     * @return JsonResponse
     */
    public function update(RemindPlanRequest $request)
    {
        $user = Auth::user();
        $plan = $user->remindPlan;
        $plan->update($request->only('active', 'schema_id'));
        return $this->sendResponse(new RemindPlanResource($plan), 'Plan updated');
    }

    public function preview(RemindPlanPreviewRequest $request)
    {
        $customer = Customer::find($request->customer_id);
        $body = $request->schema->body;
        $owner = User::find(Auth::id());

        try {
            $smsCounter = new SMSCounter();
            $previewRes = MessageService::createTextFromSchema($body, false, $customer, $owner);
            $dataInfo = $smsCounter->count($previewRes);

            return $this->sendResponse([
                'from' => $owner->name,
                'preview' => $previewRes,
                'letter_count' => $dataInfo->length,
                'letter_next_limit' => $dataInfo->length + $dataInfo->remaining,
                'sms_count' => $dataInfo->messages,
            ], 'Preview returned', 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422, 'Error during preview Generation');
        }
    }
}
