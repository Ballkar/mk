<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiCommunication;
use App\Models\Blog\Image as PostImage;
use App\Models\Blog\Post;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostImagesController extends Controller
{
    use ApiCommunication;

    public function index(Post $post)
    {
        $images = $post->images;
        return $this->sendResponse($images, 'Images returned');
    }

    public function store(Request $request, Post $post)
    {
        $request->validate(['photo' => 'required|image']);
        $path = 'posts/'.$post->id.'/';
        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $photoName = time().'.'.$extension;

        try {
            $image = Image::make($photo);
            Storage::disk('local')->put('public/'.$path.$photoName, (string) $image->encode());


            PostImage::create([
                'name' => $photoName,
                'post_id' => $post->id,
                'main' => $post->images->isEmpty() ? true : false,
            ]);

            $post = $post->find($post->id);
            return $this->sendResponse($post->images, 'New image added', 201);
        } catch (Exception $e) {
            return $this->sendError( $e->getMessage(), 500);
        }
    }

    public function changeMainImage(Request $request, Post $post)
    {
        $request->validate(['main_id' => 'required|exists:blog_posts_images,id']);

        if($old = $post->images->where('main', 1)->first()) {
            $old->update(['main' => false]);
        }

        $image = PostImage::where('id', $request->get('main_id'))->first();
        $image->update(['main' => true]);

        $post = $post->find($post->id);
        return $this->sendResponse($post, 'Main image changed');
    }

    public function delete(Request $request, Post $post, PostImage $image)
    {
        try {
            Storage::disk('local')->delete('public/posts/'.$post->id.'/'.$image->name);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
        $image->delete();

        if($image->main && $differentImage = $post->images[0]) {
            $differentImage->update([
                'main' => true,
            ]);
        }

        return $this->sendResponse(true, 'Post image deleted!', 200);
    }

}
