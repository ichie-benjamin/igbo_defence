<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
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
        $paginatedPosts = Post::published()->select('post_author','ID','post_date','post_title','post_excerpt','guid')->latest()->paginate($itemsPerType, ['*'], 'page', $page);
        $paginatedShorts = Short::latest()->paginate($itemsPerType, ['*'], 'page', $page);
        $paginatedVideos = Video::latest()->paginate($itemsPerType, ['*'], 'page', $page);
        $paginatedAds = Ads::latest()->paginate(1, ['*'], 'page', $page);

        // Construct the response array
        $data = [
            'posts' => $paginatedPosts->items(),
            'shorts' => $paginatedShorts->items(),
            'videos' => $paginatedVideos->items(),
            'ads' => $paginatedAds->items(),
            // You may want to include pagination information for each type as well
            'pagination' => [
                'current_page' => $page,
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
                ],
                'ads' => [
                    'current_page' => $paginatedAds->currentPage(),
                    'total_pages' => $paginatedAds->lastPage(),
                ]
            ]
        ];

        // Return the data as a JSON response
        return response()->json($data);
    }
    public function shorts(Request $request): JsonResponse
    {

        $itemsPerType = 5;

        $shorts = Short::latest()->paginate($itemsPerType);

        return response()->json($shorts);
    }
    public function videos(Request $request): JsonResponse
    {

        $itemsPerType = 5;

        $shorts = Video::latest()->paginate($itemsPerType);

        return response()->json($shorts);
    }
    public function increaseShortsView(Request $request): JsonResponse
    {

        $id = $request['id'];

        $short = Short::find($id);
        if($short){
            $short->views = $short->views + 1;
            $short->save();
        }

        return response()->json($short);
    }

    public function increaseVideoView(Request $request): JsonResponse
    {

        $id = $request['id'];

        $item = Video::find($id);
        if($item){
            $item->views = $item->views + 1;
            $item->save();
        }

        return response()->json($item);
    }
    public function feedsAll(Request $request): JsonResponse
    {

        $page = $request->input('page', 1);
        $itemsPerType = 4;

        // Paginate each model separately
        $paginatedPosts = Post::published()->latest()->paginate($itemsPerType, ['*'], 'page', $page);
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
