@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    <!-- the fileinput plugin styling CSS file -->
    <link href="/css/fileinput.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>  
        @include('admin.template.parts.messages')   
    </div>
    <form action="{{ route('admin.manage-post-images-upload', $post->id) }}" method="POST" enctype="multipart/form-data" accept="image/*"> 
        @csrf
        <input id="images" name="images[]" type="file" class="file" multiple 
        data-show-upload="true" data-show-caption="true" data-msg-placeholder="Selectați imaginile pentru încărcare...">
    </form>    
@endsection

@section('custom-js')
    <!-- the jQuery Library -->
    <script src="/js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <!-- the main fileinput plugin script JS file -->
    <script src="/js/fileinput.min.js"></script>
@endsection