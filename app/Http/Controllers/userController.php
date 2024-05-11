<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            try {
                $user=Auth::user();
               
                return response()->json([
                    'status'=>'succses',
                    'user'=>$user
                ]);
                } catch (\Throwable $th) {
                    \DB::rollBack();
                    
                    return response()->json([
                        'status'=>'error',
                        
                    ]);
                }
    }}

 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    { try {
        $id = Auth::user()->id;
         $user = User::find($id);
         $name = $request->name ?? $user->name;
         return response()->json([
            'status'=>$request
        ]);
         $user->name = Request::input('name');
        $user->email = Request::input('email');
         $user->save();
        return response()->json([
            'status'=>'succses',
            'user'=>$user
        ]);
        } catch (\Throwable $th) {
            \DB::rollBack();
            
            return response()->json([
                'status'=>'error',
                
            ]);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
