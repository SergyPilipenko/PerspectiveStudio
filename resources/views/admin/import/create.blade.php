@extends('admin')
@section('content')
    <form action="http://partfix.local/admin/import/parse" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="importFileUpload" class="form-control file-upload-info">
        <input type="submit" value="go">
    </form>
{{--    <div class="row m-t-20">--}}
{{--        <div class="col-md-12">--}}
{{--                <div class="box">--}}
{{--                    <div class="box-body">--}}
{{--                        <parser--}}
{{--                                :routes="'{{ $routes }}'"--}}
{{--                                :columns="'{{ $columns }}'"--}}
{{--                        ></parser>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
