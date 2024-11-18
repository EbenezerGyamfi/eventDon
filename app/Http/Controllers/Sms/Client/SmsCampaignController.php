<?php

namespace App\Http\Controllers\Sms\Client;

use App\DataTables\SmsCampaignDataTable;
use App\DataTables\SmsCampaignDetailsDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsCampaign;
use Illuminate\Http\Request;

class SmsCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SmsCampaignDataTable $dataTable)
    {
        return $dataTable->render('client.sms-campaigns.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = SmsCampaign::with(['smsHistories', 'event'])
                    ->withCount('smsHistories')
                    ->findOrFail($id);

        $delivered = $campaign->smsHistories->where('status', 'DELIVERED')->count();
        $submitted = $campaign->smsHistories->where('status', 'SUBMITTED')->count();
        $expired = $campaign->smsHistories->where('status', 'EXPIRED')->count();
        $inProgress = $campaign->smsHistories->where('status', 'IN PROGRESS')->count();
        $pending = $campaign->smsHistories->where('status', 'PENDING')->count();
        $notDelivered = $campaign->smsHistories->where('status', 'NOT_DELIVERED')->count();

        $stats = [
            'delivered' => $delivered,
            'submitted' => $submitted,
            'expired' => $expired,
            'in_progress' => $inProgress,
            'pending' => $pending,
            'not_delivered' => $notDelivered,
        ];

        $dataTable = new SmsCampaignDetailsDataTable($campaign);

        return $dataTable->render('client.sms-campaigns.show', [
            'stats' => $stats,
            'campaign' => $campaign,
            'page_title' => 'SMS Campaign Reports',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
