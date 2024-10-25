<?php

namespace App\Http\Controllers;

use App\Actions\AssignLead;
use App\Http\Requests\LeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();

        return LeadResource::collection($leads);
    }

    public function store(LeadRequest $request, AssignLead $assignLead)
    {
        $lead = Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'assignee_id' => $assignLead->execute()
        ]);

        $lead->refresh();

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => ['required']
        ]);

        $lead->update(['status' => $request->status]);

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }

    public function updateAssignee(Request $request, Lead $lead)
    {
        $request->validate([
            'assignee_id' => ['required']
        ]);

        $assignee = User::find($request->assignee_id);

        if (!$assignee) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Assignee not found'
                    ]
                ]
            ])->setStatusCode(404));
        }

        $lead->update(['assignee_id' => $request->assignee_id]);

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }
}
