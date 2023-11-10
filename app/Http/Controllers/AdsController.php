<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Video;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;
use ProtoneMedia\Splade\SpladeTable;

class AdsController extends Controller
{

    public function index(){
//        $software = $request->get('software_id');
        return view('dashboard.ads.index', [
            'data' => SpladeTable::for(Ads::class)
                ->withGlobalSearch(columns: ['title','created_at'])
                ->defaultSort('title')
                ->column(key: 'title', sortable: true)
//                ->column(key: 'description')
                ->column('file')
                ->column('created_at')

                ->column('actions')
                ->paginate(15),
        ]);
    }

    public function store(Request $request){
        $validated = $this->validateData($request);

        HandleSpladeFileUploads::forRequest($request);


        if($request->hasFile('file')){

            $path = 'ads/'.auth()->id();

            $filepath = $request->file('file')->store($path,'public');

            $validated['file'] = asset('storage/'.$filepath);
        }

        Ads::create($validated);
        Toast::title('Ads added successfully');
        return redirect()->back();
    }


    public function destroy($id){
        $item = Ads::findOrFail($id);
        $item->delete();
        Toast::title('Ads deleted successfully');
        return redirect()->back();
    }

    public function create(){
        return view('dashboard.ads.create');
    }

    private function validateData(Request $request): array
    {
        $rules = [
            'file' => 'required',
            'title' => 'required',
            'description' => 'nullable',
        ];

        return $request->validate($rules);
    }

}
