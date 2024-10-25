<?php

namespace App\Http\Controllers;

use App\Actions\CreateClientAccount;
use App\Enums\LeadStatus;
use App\Enums\ProposalStatus;
use App\Http\Requests\ProposalRequest;
use App\Http\Resources\ProposalResource;
use App\Models\Lead;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::all();

        return ProposalResource::collection($proposals);
    }

    public function store(ProposalRequest $request, Lead $lead)
    {
        $proposal = $lead->proposal()->create([
            'creator_id' => Auth::id(),
        ]);

        $proposal->refresh();

        return (ProposalResource::make($proposal))->response()->setStatusCode(201);
    }

    public function updateStatus(Request $request, Lead $lead, Proposal $proposal, CreateClientAccount $createClientAccount)
    {
        $request->validate([
            'status' => ['required'],
            'editor_id' => Auth::id(),
        ]);

        $proposal->update(['status' => $request->status]);

        $lead->update(['status' => LeadStatus::CLOSED]);

        if ($request->status == ProposalStatus::ACCEPTED->value) {
            $createClientAccount->execute($lead);
        }

        return (ProposalResource::make($proposal))->response()->setStatusCode(201);
    }
}
