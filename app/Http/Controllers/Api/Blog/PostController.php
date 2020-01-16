<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\ApiCommunication;
use App\Http\Resources\Blog\Post as PostResource;
use App\Models\Blog\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    use ApiCommunication;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->category_id) {
            $posts = Post::where('category_id', $request->category_id)->active()->latest()->paginate(10);
        } else {
            $posts = Post::latest()->active()->paginate(10);
        }
        return $this->sendResponse(new PostResource($posts), 'Posts returned', 200);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post)
    {
        return $this->sendResponse(new PostResource($post), 'Post returned', 200);
    }
}
