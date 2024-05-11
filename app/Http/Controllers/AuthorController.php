<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;;

use App\Http\Resources\AuthorResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Cache::remember('authors', 60, function () {
            return Author::all();
        });
        $data    = AuthorResource::collection($authors);
        return $this->Successfully($data, 'Successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $author = Author::create([
            'name' => $request->name,
        
        ]);
        $data = new AuthorResource($author);
        return $this->Successfully($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $data = new AuthorResource($author);
        return $this->Successfully($data, 'Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $author->name = $request->input('name') ?? $author->name;
     

        $author->save();
        $data = new AuthorResource($author);
        return $this->cSuccessfully($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->books()->detach();
        $author->delete();
        return response()->json(['message' => 'Author Deleted'], 200);
    }
}
