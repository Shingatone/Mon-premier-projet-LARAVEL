<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): view
    {
        $posts = Post::query();

        if ($search = $request->search) {
            $posts->where(fn (Builder $query) => $query
                ->where('title', 'LIKE', '%'.$search.'%')
                ->orwhere('content', 'LIKE', '%'.$search.'%')
            );
        }

        return view('posts.index', [
            'posts' => $posts->latest()->paginate(10),
        ]);
    }

    public function postsByCategory(Category $category): View
    {
        return view('posts.index', [
            /* 'posts' => $category->posts()->latest()->paginate(10), */
            'posts' => Post::where(
                'category_id', $category->id,
            )->latest()->paginate(10),
        ]);
    }
    public function postsByTag(Tag $tag): View
    {
        return view('posts.index', [
            /* 'posts' => $tag->posts()->latest()->paginate(10), */
            'posts' => Post::whereRelation(
                'tags', 'tags.id', $tag->id //on recupère tags qui ont pour id = au tag($tag->id) sur lequel je suis(tags.id)
            )->latest()->paginate(10),
        ]);
    }

    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
