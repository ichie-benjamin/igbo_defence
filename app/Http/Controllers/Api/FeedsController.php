<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Short;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class FeedsController extends Controller
{
    public function feeds(Request $request): JsonResponse
    {

        $page = $request->input('page', 1);
        $itemsPerType = 4;

        // Paginate each model separately
        $paginatedPosts = Post::select('post_author','ID','post_date','slug','title','excerpt','image')->latest()->paginate($itemsPerType, ['*'], 'page', $page);
        $paginatedShorts = Short::latest()->paginate($itemsPerType, ['*'], 'page', $page);
        $paginatedVideos = Video::latest()->paginate($itemsPerType, ['*'], 'page', $page);

        // Construct the response array
        $data = [
            'posts' => $paginatedPosts->items(),
            'shorts' => $paginatedShorts->items(),
            'videos' => $paginatedVideos->items(),
            // You may want to include pagination information for each type as well
            'pagination' => [
                'posts' => [
                    'current_page' => $paginatedPosts->currentPage(),
                    'total_pages' => $paginatedPosts->lastPage(),
                ],
                'shorts' => [
                    'current_page' => $paginatedShorts->currentPage(),
                    'total_pages' => $paginatedShorts->lastPage(),
                ],
                'videos' => [
                    'current_page' => $paginatedVideos->currentPage(),
                    'total_pages' => $paginatedVideos->lastPage(),
                ]
            ]
        ];

        // Return the data as a JSON response
        return response()->json($data);
    }
}
