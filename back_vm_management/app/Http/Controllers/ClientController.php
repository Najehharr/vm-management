<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cin' => 'required|unique:clients,cin|max:255',
            'name' => 'required|string|max:255',
            'forname' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $client = Client::create($validatedData);
        return response()->json($client, 201);
    }

    public function show($cin)
    {
        $client = Client::where('cin', $cin)->first();
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    public function update(Request $request, $cin)
    {
        $client = Client::where('cin', $cin)->first();
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'forname' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:500',
        ]);

        $client->update($validatedData);
        return response()->json($client, 200);
    }

    public function destroy($cin)
    {
        $client = Client::where('cin', $cin)->first();
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->delete();
        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
}

