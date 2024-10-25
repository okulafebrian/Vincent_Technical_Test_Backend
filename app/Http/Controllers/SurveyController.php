<?php

namespace App\Http\Controllers;

use App\Enums\LeadStatus;
use App\Enums\SurveyStatus;
use App\Http\Requests\SurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Lead;
use App\Models\Survey;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();

        return SurveyResource::collection($surveys);
    }

    public function store(SurveyRequest $request, Lead $lead)
    {
        $survey = $lead->surveys()->create([
            'notes' => $request->notes
        ]);

        $survey->refresh();

        return (SurveyResource::make($survey))->response()->setStatusCode(201);
    }

    public function updateStatus(Request $request, Lead $lead, Survey $survey)
    {
        $request->validate([
            'status' => ['required']
        ]);

        $survey->update(['status' => $request->status]);

        if ($request->status == SurveyStatus::ACCEPTED->value) {
            $lead->update(['status' => LeadStatus::PROPOSAL]);
        }

        return (SurveyResource::make($survey))->response()->setStatusCode(201);
    }
}
