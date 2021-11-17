<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmkmModel;

class UmkmController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->file('photo'));
        $data = [];
        if ($request->file('photo') == null) {
            $image = $request->input('photo_camera');
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = base64_decode($image);
            $filename = 'image_' . time() . '.png';
            file_put_contents(public_path('umkm/') . $filename, $image);
            $data += [
                'photo' => $filename
            ];
        } else {
            $filename = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('umkm'), $filename);
            $data += [
                'photo' => $filename
            ];
        }

        $data += [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'lat' => $request->input('lat'),
            'long' => $request->input('long'),
        ];

        // dd($data);
        UmkmModel::create($data);

        return redirect()->to('/home');
    }

    public function get_data()
    {
        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        $location = UmkmModel::get();
        foreach ($location as $l) {

            array_push($data['features'], [
                'type' => 'Feature',
                'properties' => [
                    'description' => "<img src='/umkm/$l->photo' style='width:100%'><br><h4 class='mt-2'>$l->name</h4><p>$l->description</p>"
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$l->long, $l->lat]
                ]
            ]);
        }

        return json_encode($data, 1);
    }
}
