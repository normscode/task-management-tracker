<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function page()
    {
        $clients = Client::latest()->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Display a listing of the clients.
     */
    public function index(Request $request): JsonResponse
    {
        //
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'entity_type' => [
                'required',
                'string',
                'in:Individual,LLC,Corporation,Partnership,Nonprofit',
            ],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        $client = Client::create($validated);

        return response()->json(['message' => 'Client created successfully.', 'data' => $client], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
        return response()->json(['data' => $client,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): JsonResponse
    {
        //
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'phone' => ['nullable', 'string', 'max:50'],
                'entity_type' => [
                    'required',
                    'string',
                    'in:Individual,LLC,Corporation,Partnership,Nonprofit',
                ],
                'status' => ['required', 'string', 'in:Active,Inactive',],
            ]
        );

        $client->update($validated);

        return response()->json(['message' => 'Client updated successfully.', 'data' => $client->fresh(),]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(['message' => 'Client archived successfully.',]);
    }
}
