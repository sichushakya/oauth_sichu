@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <span class="bg-body-secondary">{{ __('You are logged in!') }}</span>
                    </div>
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <!-- Toast messages will be appended here -->
                    </div>


                    <div class="card-header">Upload JSON File</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('upload.json') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="jsonFile">Choose JSON File</label>
                                <input type="file" class="form-control-file" id="jsonFile" name="jsonFile" accept=".json">
                                @error('jsonFile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <table class="table table-bordered">
                    @foreach($json_filenames as $json_filename)
                        <tr>
                            <td>{{ $json_filename }}</td>
                            <td><a href="{{ route('export.json') }}" class="btn btn-sm btn-outline-secondary">Export</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>



@endsection
