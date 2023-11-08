<?php

namespace App\Http\Controllers;

use App\Models\Short;
use App\Models\Video;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;
use ProtoneMedia\Splade\SpladeTable;

class ShortController extends Controller
{

    public function index(){
//        $software = $request->get('software_id');
        return view('dashboard.shorts.index', [
            'data' => SpladeTable::for(Short::class)
                ->withGlobalSearch(columns: ['title','tags'])
                ->defaultSort('title')
                ->column(key: 'title', sortable: true)
                ->column(key: 'tags', sortable: true)
//                ->column(key: 'description')
                ->column('file')
                ->column('created_at')

                ->column('actions')
                ->paginate(15),
        ]);
    }

    public function store(Request $request){
        $validated = $this->validateData($request);
        $validated['user_id'] = auth()->id();

        HandleSpladeFileUploads::forRequest($request);


        if($request->hasFile('file')){

            $path = 'shorts/'.auth()->id();

            $filepath = $request->file('file')->store($path,'public');

            $validated['file'] = asset('storage/'.$filepath);
        }

        Short::create($validated);
        Toast::title('Short added successfully');
        return redirect()->back();
    }

    public function update(Request $request, Video $video){
        $validated = $this->validateData($request, $video->id);

        HandleSpladeFileUploads::forRequest($request);


        if($request->hasFile('file')){
            $path = 'shorts/'.auth()->id();

            $filepath = $request->file('file')->store($path,'public');

            $validated['file'] = asset('storage/'.$filepath);
        }

        $video->update($validated);

        Toast::title('Short updated successfully');

        return redirect()->back();
    }

    public function create(){
        return view('dashboard.shorts.create');
    }


    public function edit(Short $short){
        return view('dashboard.shorts.edit', compact('short'));
    }

    public function destroy($id){
        $short = Short::findOrFail($id);
        $short->delete();
        Toast::title('Short deleted successfully');
        return redirect()->back();
    }
    private function validateData(Request $request, $id = null): array
    {
        $rules = [
            'file' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'tags' => 'nullable',
        ];

        return $request->validate($rules);
    }
}
