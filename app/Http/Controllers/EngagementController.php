<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Engagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EngagementController extends Controller
{
    public function page()
    {
        $engagements = Engagement::with('client')
            ->latest()
            ->get();

        $clients = Client::orderBy('name')->get();

        return view('engagements.index', compact(
            'engagements',
            'clients'
        ));
    }

    public function index(Request $request): JsonResponse
    {
        $query = Engagement::with('client');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query->whereHas('client', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('service_type', 'like', "%{$search}%")
                    ->orWhere('tax_year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return response()->json(
            $query->latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                'exists:clients,id',
            ],
            'service_type' => [
                'required',
                'string',
                'in:Tax Preparation,Bookkeeping,Tax Consultation,Payroll,Other',
            ],
            'tax_year' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                'string',
                'in:Open,In Progress,Completed,Cancelled',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $client = Client::findOrFail($validated['client_id']);

        if ($client->trashed()) {
            return response()->json([
                'message' => 'Cannot create an engagement for an archived client.',
            ], 422);
        }

        $engagement = Engagement::create($validated);

        $engagement->load('client');

        return response()->json([
            'message' => 'Engagement created successfully.',
            'data' => $engagement,
        ], 201);
    }

    public function show(Engagement $engagement): JsonResponse
    {
        $engagement->load('client');

        return response()->json([
            'data' => $engagement,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(
        Request $request,
        Engagement $engagement
    ): JsonResponse {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'integer',
                'exists:clients,id',
            ],
            'service_type' => [
                'required',
                'string',
                'in:Tax Preparation,Bookkeeping,Tax Consultation,Payroll,Other',
            ],
            'tax_year' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                'string',
                'in:Open,In Progress,Completed,Cancelled',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $client = Client::findOrFail($validated['client_id']);

        if ($client->trashed()) {
            return response()->json([
                'message' => 'Cannot assign an engagement to an archived client.',
            ], 422);
        }

        $engagement->update($validated);

        $engagement->load('client');

        return response()->json([
            'message' => 'Engagement updated successfully.',
            'data' => $engagement,
        ]);
    }

    public function destroy(Engagement $engagement): JsonResponse
    {
        $engagement->delete();

        return response()->json([
            'message' => 'Engagement deleted successfully.',
        ]);
    }
}
