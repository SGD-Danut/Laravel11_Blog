@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    <!-- the fileinput plugin styling CSS file -->
    <link href="/css/fileinput.min.css" rel="stylesheet" type="text/css" />
    <!-- Magnific Popup core CSS file -->
    <link href="/css/magnific-popup.css" rel="stylesheet" type="text/css" />
@endsection

@section('above-content')
    @if ($postImages->count() > 0)
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <form id="delete-post-image-form-with-id-{{ $post->id }}" action="{{ route('admin.manage-post-images-delete', $post->id) }}" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                    <button type="button" class="btn btn-danger" onclick="
                    if(confirm('Sigur ștergeți toată galeria?')) {
                        document.getElementById('delete-post-image-form-with-id-' + {{ $post->id }}).submit();
                    }
                    ">Șterge toată galeria</button>
                    <a class="badge bg-dark text-white ms-2">
                        {{ $postImages->total() }}
                    </a>
                    <h1 class="h3 d-inline align-middle">Imaginile acestei postări:</h1>
                </div>
                {{ $postImages->links() }}
                <div class="row">
                    @foreach ($postImages as $image)
                        <div class="col-12 col-md-3">
                            <div class="card">
                                <div class="popup-gallery">
                                    <a href="{{ $image->imageUrl() }}" title="Imagine">
                                        <img class="card-img-top" src="{{ $image->imageUrl() }}" alt="Unsplash">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <form id="edit-image-for-{{ $image->id }}" action="{{ route('admin.manage-post-images.update-image', $image->id) }}" method="POST" enctype="multipart/form-data" accept="image/*">
                                        @csrf
                                        @method('put')
                                        <div class="mb-3">
                                            <input type="text" class="form-control" aria-describedby="titleHelp" name="title" value="{{ $image->title }}" placeholder="Titlu imagine">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" aria-describedby="descriptionHelp" name="description" value="{{ $image->description }}" placeholder="Descriere imagine">
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-5">
                                                <label for="InputPosition" class="form-label">Poziție imagine</label>
                                                <input type="number" class="form-control" id="InputPosition" aria-describedby="positionHelp" name="position" value="{{ $image->position }}">
                                            </div>
                                            <div class="mb-3 col-md-7">
                                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ $image->published == 1 ? 'checked' : ''}}>
                                                <label class="form-check-label" for="flexCheckDefaultForPublished">Imagine publică</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Înlocuiți cu o altă imagine</label>
                                            <input class="form-control" type="file" accept="image/*" name="image" id="image">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Actualizează imagine</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </main>
    @endif
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title . ': ' . $post->title }}</h5>  
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
    <!-- fileinput plugin script validation -->
    {{-- <script>
        $("#images").fileinput({
            maxFileCount: 6,
            validateInitialCount: true,
            allowedFileExtensions: ["jpg", "jpeg", "png", "gif"]
        });
    </script> --}}
    <!-- Magnific Popup core JS file -->
    <script src="/js/jquery.magnific-popup.min.js"></script>
    {{-- Script for initialization of the magnific-popup: --}}
    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title') + ' oferită de Blog';
                    }
                }
            });
        });
    </script>
@endsection