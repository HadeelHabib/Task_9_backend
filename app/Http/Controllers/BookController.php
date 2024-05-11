<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;;
use App\Http\Resources\BookResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Cache::remember('books', 60, function () {
            return Book::all();
        });
        $data  = BookResource::collection($books);
        return $this->Successfully($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   
    {
  $request->validate(
  [
      'name'=>'required|string',
      'genre'=>'required|string',
      'publish_date'=>'required|string',
  ]);


  try {
      \DB::beginTransaction();
     
      $book=Book::create([
          'name'=>$request->name ,
          'publish_date'=>$request->publish_date ,
          'genre'=>$request->genre ,
      ]);
      $book->author()->attach($request->author_id,[
          'available'=>true,
      ]);
      \DB::commit();
      $data = new AuthorResource($book);
      return $this->Successfully($data, 'Created Successfully', 201);
  } catch (\Throwable $th) {
      \DB::rollBack();
      
      return response()->json([
          'status'=>'error',
          
      ]);
  }}

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $data = new BookResource($book);
        return $this->Successfully($data, 'Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->authors()->detach();
        $book->delete();
        return response()->json(['message' => 'Book Deleted'], 200);
    }
}
 
 
 

 
 
 
 