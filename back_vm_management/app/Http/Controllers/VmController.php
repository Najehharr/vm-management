<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VM;
use App\Models\Server;
use App\Models\Client;
use App\Models\Allocation;


class VmController extends Controller
{

    public function index()
    {
        $vms = VM::with(['server', 'client', 'allocations'])->get();

        return response()->json($vms->map(function ($vm) {
            $allocation = $vm->allocations->first(); 

            return [
                'id' => $vm->id,
                'server_id' => $vm->server->id ?? 'N/A',
                'client_cin' => $vm->client->cin ?? 'N/A',
                'begin_date' => $allocation->begin_date ?? 'N/A',
                'end_date' => $allocation->end_date ?? 'N/A',
                'amount' => $allocation->amount ?? 'N/A',
            ];
        }), 200);
    }







    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'price' => 'required|numeric',
                'ram' => 'required|string',
                'disk' => 'required|string',
                'os' => 'required|string',
                'hypervisor' => 'required|string',
                'client_cin' => 'required|string',
                'client_name' => 'required|string',
                'client_forname' => 'required|string',
            ]);

            $server = Server::create([
                'ram' => $validatedData['ram'],
                'disk' => $validatedData['disk'],
                'hypervisor' => $request->input('hypervisor', 'default_value'),
            ]);

            $client = Client::firstOrCreate([
                'cin' => $request->input('client_cin'),
            ], [
                'name' => $request->input('client_name'),
                'forname' => $request->input('client_forname'),
                'address' => $request->input('client_address', 'Unknown Address'),
            ]);

            $vm = VM::create([
                'price' => $validatedData['price'],
                'ram' => $validatedData['ram'],
                'disk' => $validatedData['disk'],
                'os' => $validatedData['os'],
                'server_id' => $server->id,
                'client_cin' => $client->cin,
            ]);

            $allocation =Allocation::create([
                'client_cin' => $client->cin,
                'vm_id' => $vm->id,
                'begin_date' => now(),
                'end_date' => now()->addMonths(1),
                'amount' => $validatedData['price'],
            ]);
            if (!$allocation) {
                throw new \Exception('Failed to create Allocation');
            }


            $vm->update(['allocation_id' => $allocation->id]);
            return response()->json($vm, 201);
        } catch (\Exception $e) {
            \Log::error('VM Creation Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating VM',
                'error' => $e->getMessage()
            ], 500);
        }
    }







    public function show($id)
    {
        $vm = VM::with(['server', 'client', 'allocations'])->find($id);

        if (!$vm) {
            return response()->json(['message' => 'Virtual Machine not found.'], 404);
        }

        return response()->json($vm, 200);
    }




    public function update(Request $request, $id)
    {
        $vm = VM::find($id);

        if (!$vm) {
            return response()->json(['message' => 'Virtual Machine not found.'], 404);
        }

        $validatedData = $request->validate([
            'price' => 'numeric',
            'ram' => 'numeric',
            'disk' => 'numeric',
            'os' => 'string',
            'server_id' => 'integer|exists:servers,id',
            'client_cin' => 'integer|exists:clients,id',
            'allocation_id' => 'integer|exists:allocations,id',
        ]);

        $vm->update($validatedData);

        return response()->json([
            'message' => 'Virtual Machine updated successfully.',
            'vm' => $vm,
        ], 200);
    }





    public function destroy($id)
    {
        $vm = VM::find($id);

        if (!$vm) {
            return response()->json(['message' => 'Virtual Machine not found.'], 404);
        }

        $vm->delete();

        return response()->json(['message' => 'Virtual Machine deleted successfully.'], 200);
    }
}
