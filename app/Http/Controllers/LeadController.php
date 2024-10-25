<?php

namespace App\Http\Controllers;

use App\Actions\AssignLead;
use App\Http\Requests\LeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'salesperson_id' => $assignLead->execute(),
            'creator_id' => Auth::id()
        ]);

        $lead->refresh();

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => ['required']
        ]);

        $lead->update([
            'status' => $request->status,
            'editor_id' => Auth::id(),
        ]);

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }

    public function updateSalesperson(Request $request, Lead $lead)
    {
        $request->validate([
            'salesperson_id' => ['required'],
        ]);

        $salesperson = User::find($request->salesperson_id);

        if (!$salesperson) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Salesperson not found'
                    ]
                ]
            ])->setStatusCode(404));
        }

        $hasActivePenalty = $salesperson->salespersonPenalties()
            ->where('start', '<=', Carbon::now())
            ->where('end', '>=', Carbon::now())
            ->exists();

        if ($hasActivePenalty) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Salesperson has penalty'
                    ]
                ]
            ])->setStatusCode(404));
        }

        $lead->update([
            'salesperson_id' => $request->salesperson_id,
            'editor_id' => Auth::id(),
        ]);

        return (LeadResource::make($lead))->response()->setStatusCode(201);
    }
}
