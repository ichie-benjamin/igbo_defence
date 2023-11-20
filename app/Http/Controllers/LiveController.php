<?php

namespace App\Http\Controllers;

use App\Models\Live;

use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class LiveController extends Controller
{

    public function index(){
//        $software = $request->get('software_id');
        return view('dashboard.live.index', [
            'data' => SpladeTable::for(Live::class)
                ->withGlobalSearch(columns: ['title'])
                ->defaultSort('title')
                ->column(key: 'title', sortable: true)
//                ->column(key: 'description')
                ->column('link')
                ->column('created_at')

                ->column('actions')
                ->paginate(15),
        ]);
    }

    public function store(Request $request){
        $validated = $this->validateData($request);

        Live::create($validated);
        Toast::title('Live added successfully');
        return redirect()->back();
    }

    public function update(Request $request, Live $live){
        $validated = $this->validateData($request, $live->id);

        $live->update($validated);

        Toast::title('Live updated successfully');

        return redirect()->back();
    }

    public function create(){
        return view('dashboard.live.create');
    }


    public function edit(Live $live){
        return view('dashboard.live.edit', compact('live'));
    }

    public function destroy($id){
        $short = Live::findOrFail($id);
        $short->delete();
        Toast::title('Live deleted successfully');
        return redirect()->back();
    }
    private function validateData(Request $request, $id = null): array
    {
        $rules = [
            'title' => 'required',
            'link' => 'required',
        ];

        return $request->validate($rules);
    }
}
