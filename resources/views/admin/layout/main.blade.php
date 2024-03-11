@extends("voyager::master")
@section('page_title')
    @yield('title')
@endsection
@section('css')
    @include('admin.layout.import_css')
@endsection
@section('page_header')
    @yield('header')
@endsection
@section('content')
    @yield('page_content')
@endsection
@section('javascript')
    @yield('global_js')
    @include('admin.layout.import_js')
    <script>
        @if(Session::has('message'))
        @php
            $data_msg = session()->pull('message');
        @endphp
        showToast("{{$data_msg['type']}}", "{{__('message.notification')}}", "{{$data_msg['content']}}", {position: 'topRight'});
        @endif
    </script>
    @yield('js')
@endsection
