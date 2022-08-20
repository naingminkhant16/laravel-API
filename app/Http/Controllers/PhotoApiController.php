<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Photo::latest('id')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => "required|exists:products,id",
            'photos' => 'required',
            "photos.*" => 'required|file|mimes:png,jpg|max:512'
        ]);

        foreach ($request->photos as $photo) {
            $pathName = $photo->store('public');

            Photo::create([
                'product_id' => $request->product_id,
                'name' => $pathName
            ]);
        }

        return response()->json(['message' => "Photos are uploaded."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);

        if (!$photo) return response()->json(['message' => "Photo is not found"], 404);

        $photo->delete();

        return  response()->json(['message' => "Photo is deleted"], 204);
    }
}
