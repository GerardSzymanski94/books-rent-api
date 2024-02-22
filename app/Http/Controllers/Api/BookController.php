<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApiStatusEnum;
use App\Enums\RentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentBookRequest;
use App\Http\Resources\BookDetailsResource;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Client;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(20);
        return BookResource::collection($books);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if(!$book){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Book not found'], 404);
        }
        return new BookDetailsResource($book);
    }

    public function search($search)
    {
        $books = Book::where('name', 'like', "%$search%")
            ->orWhere('author', 'like', "%$search%")
            ->orWhereHas('clients', function ($clients) use($search){
                $clients->where('status', RentStatusEnum::RENT)->whereHas('client', function($client) use($search){
                   $client->where('first_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
                });
            })
            ->paginate(20);
        return BookDetailsResource::collection($books);
    }

    public function rent(RentBookRequest $request)
    {
        $client = Client::find($request->client_id);
        if(!$client){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Client not found'], 404);
        }
        $book = Book::find($request->book_id);
        if(!$book){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Book not found'], 404);
        }

        if(!$book->isAvailable()){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'The book is already rent'], 400);
        }
        try{
            $book->rent($client);
        }catch(\Exception $ex){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => $ex->getMessage()], 500);
        }
        return response()->json([
            'STATUS' => ApiStatusEnum::SUCCESS,
            'book' => new BookDetailsResource($book)
        ]);

    }

    public function return($bookId)
    {
        $book = Book::find($bookId);
        if(!$book){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'Book not found'], 404);
        }
        if($book->isAvailable()){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => 'The book is already available'], 400);
        }
        try{
            $book->return();
        }catch(\Exception $ex){
            return response()->json(['STATUS' => ApiStatusEnum::ERROR, 'message' => $ex->getMessage()], 500);
        }
        return response()->json([
            'STATUS' => ApiStatusEnum::SUCCESS,
            'book' => new BookDetailsResource($book)
        ]);
    }
}
