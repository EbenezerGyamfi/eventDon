<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use Illuminate\Http\Request;

class HandleSmsWebhook extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $smsHistory = SmsHistory::with('smsCampaign')->where('sms_id', request()->query('sms_id'))->first();

        if (is_null($smsHistory)) {
            abort(404);
        }

        $data = [];

        $status = request()->query('status');

        switch ($status) {
            case 'DELIVERED':
                $data = [
                    'status' => $status,
                ];

                $smsHistory->update($data);

                if (! is_null($smsHistory->sms_campaign_id)) {
                    $smsCampaign = $smsHistory->smsCampaign;

                    $smsCampaign->increment('total_delivered');

                    if ($smsCampaign->number_of_recipients == $smsCampaign->total_delivered) {
                        $smsCampaign->update([
                            'completion_time' => now()->toDateTimeString(),
                            'status' => 'COMPLETED',
                        ]);
                    }
                }
                break;

            default:
                $data = [
                    'status' => $status,
                ];

                $smsHistory->update($data);
                break;
        }

        return response(['status' => 'SMS Updated']);
    }
}
