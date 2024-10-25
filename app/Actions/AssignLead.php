<?php

namespace App\Actions;

use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignLead
{
    public function execute()
    {
        $leadCount = Lead::count();
        $salespeople = User::where('role_id', 3)
            ->whereDoesntHave('salespersonPenalties', function ($query) {
                $query->where('start', '<=', Carbon::now())
                    ->where('end', '>=', Carbon::now());
            })
            ->get();

        if (!$salespeople) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Salespeopel not available'
                    ]
                ]
            ])->setStatusCode(404));
        }

        $index = $leadCount % $salespeople->count();

        $nextSalesperson = $salespeople[$index];

        return $nextSalesperson->id;
    }
}
