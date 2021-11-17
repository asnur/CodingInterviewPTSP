@extends('layouts.app')
@extends('layouts.nav')
@php
$no = 1;
@endphp

@section('content')
    <div id="map" style="width:100%; height:100vh"></div>
    <pre id="coordinates" class="coordinates"></pre>
    <div class="btn-add-cordinate">
        <a class="btn btn-sm btn-success" data-toggle="modal" data-target=".form-add-cordinate"><i class="fa fa-plus"></i>
            Add New Location</a>
        {{-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target=".data-cordinate"><i class="fa fa-table"></i>
            View Location</a> --}}
    </div>
    {{-- <div class="modal fade data-cordinate" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fa fa-map-marker"></i> Data Location</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped w-100" id="table">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Description</th>
                        </thead>
                        <tfoot>
                            <th>No</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Description</th>
                        </tfoot>
                        <tbody>
                            @foreach ($umkm as $u)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td><img src="{{ asset('umkm') }}/{{ $u->photo }}"
                                            style="width:200px;height:100px;object-fit:cover;"></td>
                                    <td>{{ $u->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <form action="{{ route('save-location') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade form-add-cordinate" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h3><i class="fa fa-map-marker"></i> Add New Location</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="label font-weight-bold">Latitude</label>
                                <input type="text" class="form-control" name="lat" id="latitude"
                                    placeholder="Input Latitude Coordinate">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="label font-weight-bold">Longitude</label>
                                <input type="text" class="form-control" name="long" id="longitude"
                                    placeholder="Input Longitude Coordinate">
                            </div>
                            <div class="col-md-12">
                                <input type="checkbox" id="manual_input" class="mt-2 mb-3"> Detec Your Location ?
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="label font-weight-bold">Name Location</label>
                                <input type="text" class="form-control" name="name" placeholder="Input name location"
                                    required>
                            </div>
                            <div class="col-md-8 mb-2">
                                <label class="label font-weight-bold">Photo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo" id="customFile"
                                        onchange="readURL(this)">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <br>
                                {{-- <a href="#" onclick="openCamera()" style="padding-top: 10px">Use Camera</a> --}}
                            </div>
                            <div class="col-md-4 mb-2">
                                <img src="data:image/png;base64,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"
                                    class="w-100" id="img-location">
                                {{-- <input type="hidden" id="image_camera" name="photo_camera">
                                <div id="camera" style="width: 100%; height:200px"></div>
                                <center>
                                    <a href="#" class="btn btn-sm btn-success mt-2" id="take-snapshot"
                                        onclick="preview_image()">Take
                                        Snapshot</a>
                                </center> --}}
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="label font-weight-bold">Description</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Input Description"
                                    required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-primary">
                        <button type="submit" class="btn btn-md btn-success"><i class="fa fa-paper-plane"></i> Send
                            Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
