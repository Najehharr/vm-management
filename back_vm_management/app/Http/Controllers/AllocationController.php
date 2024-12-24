<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\AllocationEmail;
use App\Models\Allocation;
use Illuminate\Http\Request;

class AllocationController extends Controller
{

    public function index()
{
    // Eager load the 'client' relationship
    $allocations = Allocation::with('client')->get();

    // Map the allocations to include relevant data from both Allocation and Client
    $allocations = $allocations->map(function ($allocation) {
        return [
            'id' => $allocation->id,
            'vm_id' => $allocation->vm_id,
            'client_cin' => $allocation->client->cin,  // Retrieve CIN from the client
            'address' => $allocation->client->address,  // Retrieve email from the client
            'begin_date' => $allocation->begin_date,
            'end_date' => $allocation->end_date,
            'amount' => $allocation->amount,
        ];
    });

    return response()->json($allocations);
}


    //

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_cin' => 'required|exists:clients,cin',
            'vm_id' => 'required|exists:vms,id',
            'begin_date' => 'required|date',
            'end_date' => 'required|date|after:begin_date',
            'amount' => 'required|numeric|min:0',
        ]);

        $allocation = Allocation::create($validatedData);

        return response()->json($allocation, 201);
    }
    //


    public function show($id)
    {
        $allocation = Allocation::find($id);

        if (!$allocation) {
            return response()->json(['error' => 'Allocation not found'], 404);
        }

        return response()->json($allocation, 200);
    }

    //


    public function update(Request $request, $id)
    {
        $allocation = Allocation::find($id);

        if (!$allocation) {
            return response()->json(['error' => 'Allocation not found'], 404);
        }

        $validatedData = $request->validate([
            'client_cin' => 'exists:clients,cin',
            'vm_id' => 'exists:vms,id',
            'begin_date' => 'date',
            'end_date' => 'date|after:begin_date',
            'amount' => 'numeric|min:0',
        ]);

        $allocation->update($validatedData);

        return response()->json($allocation, 200);
    }


    //

    public function destroy($id)
    {
        $allocation = Allocation::find($id);

        if (!$allocation) {
            return response()->json(['error' => 'Allocation not found'], 404);
        }

        $allocation->delete();

        return response()->json(['message' => 'Allocation deleted successfully'], 200);
    }

    //


    public function getClientEmail($cin)
    {
        $client = Client::where('cin', $cin)->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json(['address' => $client->address]);
    }


    //

    public function sendAllocationEmail(Request $request)
{
    // Validate incoming request
    $validatedData = $request->validate([
        'client_cin' => 'required|exists:clients,cin',
        'allocation.id' => 'required|exists:allocations,id',
    ]);

    try {
        // Find the client using the CIN
        $client = Client::where('cin', $validatedData['client_cin'])->first();
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        // Find the allocation using the provided allocation ID
        $allocation = Allocation::find($validatedData['allocation']['id']);
        if (!$allocation) {
            return response()->json(['error' => 'Allocation not found'], 404);
        }


        if (!$client->address) {
            return response()->json(['error' => 'Client email address is missing'], 400);
        }

        // Sending the email
        Mail::to($client->address)->send(new AllocationEmail($allocation));

        // Success response
        return response()->json(['message' => 'Email sent successfully!'], 200);
    } catch (\Exception $e) {
        // Catch and return any errors during the process
        return response()->json(['message' => 'Error sending email', 'error' => $e->getMessage()], 500);
    }
}



    public function getAllClientsCINs()
    {
        $clients = Client::select('cin')->get();

        if ($clients->isEmpty()) {
            return response()->json(['error' => 'No clients found'], 404);
        }

        return response()->json($clients);
    }




}


