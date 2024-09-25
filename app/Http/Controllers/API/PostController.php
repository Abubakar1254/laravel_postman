<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController AS BaseController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::all();
        return $this->sendResponse($data, 'All Post Data.'); // Added comma
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validateUser->fails()) {
            return $this->sendError('Validation Error', $validateUser->errors()->all());
        }

        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path('uploads'), $imageName);
        
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);
        
        return $this->sendResponse($post, 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Post::select('id', 'title', 'description', 'image')->where('id', $id)->first();
        
        return $this->sendResponse($data, 'You single post.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validateUser->fails()) {
            return $this->sendError('Validation Error', $validateUser->errors()->all());
        }

        $postImage = Post::select('id', 'image')->where('id', $id)->first();

        if ($request->hasFile('image')) {
            $path = public_path('uploads');

            if ($postImage->image && file_exists($path . '/' . $postImage->image)) {
                unlink($path . '/' . $postImage->image);
            }

            $img = $request->image;
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $img->move($path, $imageName);
        } else {
            $imageName = $postImage->image;
        }

        $post = Post::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);
 
        return $this->sendResponse($post, 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $imagePath = public_path('uploads/' . $post->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $post->delete();
        return $this->sendResponse(null, 'Your Post Has Been Removed'); // Set to null for no data
    }
}