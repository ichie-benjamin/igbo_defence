<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;
use ProtoneMedia\Splade\SpladeTable;

class VideoController extends Controller
{


    public function index(){
//        $software = $request->get('software_id');
        return view('dashboard.videos.index', [
            'data' => SpladeTable::for(Video::class)
                ->withGlobalSearch(columns: ['title','tags'])
                ->defaultSort('title')
                ->column(key: 'title', sortable: true)
                ->column(key: 'tags', sortable: true)
//                ->column(key: 'description')
                ->column('video')
                ->column('created_at')

                ->column('actions')
                ->paginate(15),
        ]);
    }

    public function store(Request $request){
        $validated = $this->validateData($request);
        $validated['user_id'] = auth()->id();

        HandleSpladeFileUploads::forRequest($request);


        if($request->hasFile('video')){

            $path = 'videos/'.auth()->id();

            $filepath = $request->file('video')->store($path,'public');

            $validated['video'] = asset('storage/'.$filepath);
        }

        Video::create($validated);
        Toast::title('Premium video added successfully');
        return redirect()->back();
    }

    public function update(Request $request, Video $video){
        $validated = $this->validateData($request, $video->id);

        HandleSpladeFileUploads::forRequest($request);


        if($request->hasFile('video')){
            $path = 'videos/'.auth()->id();

            $filepath = $request->file('video')->store($path,'public');

            $validated['video'] = asset('storage/'.$filepath);
        }

        $video->update($validated);

        Toast::title('Video updated successfully');

        return redirect()->back();
    }

    public function create(Request $request){
        return view('dashboard.videos.create');
    }


    public function edit(Video $video){
        return view('dashboard.versions.edit', compact('video'));
    }

    public function destroy(Video $video){
        $video->delete();
        Toast::title('Video deleted successfully');
        return redirect()->back();
    }
    private function validateData(Request $request, $id = null): array
    {
        $rules = [
            'video' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'tags' => 'nullable',
        ];

        return $request->validate($rules);
    }
}
