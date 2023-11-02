<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\sites;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class MainController extends Controller
{

    public function checkSite(Request $request): JsonResponse
    {
        //Status
        $validated = $request->validate([
            'username' => 'nullable',
            'purchase_key' => 'nullable',
            'application_key' => 'nullable',
            'software_id' => 'nullable',
            'domain' => 'required',
        ]);

        $validated['purchase_key'] = $validated['application_key'];
        $validated['buyer_name'] = $validated['username'];

        $data['active'] = 0;

        $license = Site::where('domain',$validated['domain'])->first();
        if($license){
            if($license->status == 1){
                $data['active'] = 1;
            }
            if($license->status != 1){
                if($validated['purchase_key']){
                    $key = Site::where('license',$validated['purchase_key'])->first();
                    if($key && !$key->domain){
                        $key->domain = $validated['domain'];
                        $key->software_id = $validated['software_id'];
                        $key->buyer_name = $validated['username'];
                        $key->status = 1;
                        $key->save();
                        Site::where('domain', $validated['domain'])->where('status','!=', 1)
                            ->delete();
                        $data['active'] = $key->status;
                    }
                }
            }
        }
        if(!$license){
            if($validated['purchase_key']){
                //check if purchase key exist
                $key = Site::where('license',$validated['purchase_key'])->first();
                if($key){
                    //check if purchase key is available
                    if(!$key->domain){
                        $key->domain = $validated['domain'];
                        $key->software_id = $validated['software_id'];
                        $key->buyer_name = $validated['username'];
                        $key->status = 1;
                        $key->save();
                        $data['active'] = $key->status;
                    }else if ($key->domain != $validated['domain']){
                        Site::create($validated);
                    }
                }
                if(!$key){
                    //check codecayon server
                    $data['active'] = 1;
                }
            }else{
                Site::create($validated);
            }
        }
        return response()->json($data);
    }
    public function addSite(Request $request): JsonResponse
    {
        $site = sites::whereUrl($request['url'])->first();
        if(!$site){
            $site = new sites();
            $site->name = $request['name'];
            $site->url = $request['url'];
            $site->save();
        }
        return response()->json($site);
    }

}
