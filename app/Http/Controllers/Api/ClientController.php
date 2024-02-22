<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApiStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Resources\BookDetailsResource;
use App\Http\Resources\ClientDetailsResource;
use App\Http\Resources\ClientResource;
use App\Models\Book;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(20);
        return ClientResource::collection($clients);
    }


    public function show($id)
    {
        $client = Client::find($id);
        return new ClientDetailsResource($client);
    }

    public function store(ClientStoreRequest $request){
        $data = $request->validated();
        $client = Client::create($data);
        return response()->json([
            'STATUS' => ApiStatusEnum::SUCCESS,
            'client' => new ClientResource($client)
        ]);
    }
    public function update($id, ClientUpdateRequest $request){

        $client = Client::find($id);
        if(!$client){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Client not found'], 404);
        }

        $data = $request->validated();

        $client->update($data);
        $client = $client->refresh();
        return response()->json([
            'STATUS' => ApiStatusEnum::SUCCESS,
            'client' => new ClientResource($client)
        ]);
    }
    public function destroy($id){

        $client = Client::find($id);
        if(!$client){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Client not found'], 404);
        }
        try{
            $client->delete();
        }catch(\Exception $ex){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => $ex->getMessage()], 500);
        }
        return response()->json([
            'STATUS' => ApiStatusEnum::SUCCESS
        ]);


    }
}
