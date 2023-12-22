<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::all();
        return PostDetailResource::collection($posts->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,commentContents']));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post->loadMissing(['writer:id,username', 'comments:id,post_id,user_id,commentContents']));
    }

    public function authorPost($id)
    {
        $post = Post::where('author', $id)->get();
        return PostDetailResource::collection($post->loadMissing('writer:id,username'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'newsContent' => 'required',
        ]);

        // upload file
        if ($request->file) {
            $fileName = Str::random(15);
            $extension = $request->file->extension();
            $validExtension = ['png', 'jpg', 'jpeg', 'heic', 'gif', 'bmp', 'svg', 'webp'];
            $imageName = $fileName . '.' . $extension;
            $condition = in_array($extension, $validExtension);
            if ($condition == true) {
                Storage::putFileAs('image', $request->file, $imageName);
                $request['image'] = $imageName;
            } else {
                return 'You must upload file image';
            }
        }
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        if (isset($request['title']) && isset($request['newsContent'])) {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'newsContent' => 'required',
            ]);
        }

        // upload file
        if ($request->file) {
            $fileName = Str::random(15);
            $extension = $request->file->extension();
            $validExtension = ['png', 'jpg', 'jpeg', 'heic', 'gif', 'bmp', 'svg', 'webp'];
            $imageName = $fileName . '.' . $extension;
            $condition = in_array($extension, $validExtension);
            if ($condition == true) {
                Storage::putFileAs('image', $request->file, $imageName);
                $request['image'] = $imageName;
            } else {
                return 'image file is not valid';
            }
        }



        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
