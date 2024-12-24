<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\VM;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServerController extends Controller
{


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ram' => 'required|string|max:255',
            'disk' => 'required|string|max:255',
            'hypervisor' => 'required|string|max:255',
        ]);

        $server = Server::find($id);

        if (!$server) {
            return response()->json(['error' => 'Server not found'], 404);
        }

        $server->update($validatedData);

        return response()->json(['message' => 'Server updated successfully', 'server' => $server], 200);
    }


        public function destroy($id)
        {

            $server = Server::findOrFail($id);
            $server->delete();

            return response()->json(['message' => 'Server deleted successfully!']);
        }





    public function index(){
        $servers = Server::all();

        return response()->json($servers);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ram' => 'required|string',
            'disk' => 'required|string',
            'allocation_id' => 'required|exists:allocations,id',
            'client_cin' => 'required|exists:clients,cin',
            'price' => 'required|numeric|min:0',
        ]);


        $server = Server::create([
            'ram' => $validatedData['ram'],
            'disk' => $validatedData['disk'],

        ]);


        $vmData = [
            'ram' => $validatedData['ram'],
            'disk' => $validatedData['disk'],
            'server_id' => $server->id,
            'client_cin' => $validatedData['client_cin'],
            'price' => $validatedData['price'],
        ];

        $vm = VM::create($vmData);



        $beginDate = Carbon::now();
        $endDate = $beginDate->copy()->addYear();

        $allocationData = [
            'vm_id' => $vm->id,
            'client_cin' => $validatedData['client_cin'],
            'begin_date' => $beginDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'amount' => $validatedData['price'],
        ];

        $allocation = Allocation::create($allocationData);

        return response()->json([
            'server' => $server,
            'vm' => $vm,
            'allocation' => $allocation
        ], 201);
    }
}
