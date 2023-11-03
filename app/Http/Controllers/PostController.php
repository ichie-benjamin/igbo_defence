<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;

class PostController extends Controller
{
    public function index(){
//        $software = $request->get('software_id');
        return view('dashboard.posts.index', [
            'data' => SpladeTable::for(Post::published()->latest())
                ->withGlobalSearch(columns: ['post_title','post_excerpt'])
                ->defaultSort('post_title')
                ->column(key: 'post_title', sortable: true)
//                ->column('thumbnail')
                ->column('created_at')

                ->column('actions')
                ->paginate(15),
        ]);
    }
    public function all(){
        $post = Post::published()->latest()->paginate(10);
        return $post;
    }
}
