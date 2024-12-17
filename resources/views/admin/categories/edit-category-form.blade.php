@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    {{-- Margini tabel datatables CSS custom: --}}
    <style>
        #datatables_wrapper {
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>     
    </div>
    @include('admin.template.parts.messages')
    <form action="{{ route('admin.update-category', $category->id) }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
        @method('put')
        @csrf
        <div class="mb-3 col-md-4">
            <label for="InputTitle" class="form-label">Nume</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') ? old('title') : $category->title }}">
            @error('title')
                <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="InputSlug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="InputSlug" aria-describedby="slugHelp" name="slug" value="{{ old('slug') ? old('slug') : $category->slug }}">
            @error('slug')
                <div id="slugHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="InputSubtitle" class="form-label">Subtitlu</label>
            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="InputSubtitle" aria-describedby="subtitleHelp" name="subtitle" value="{{ old('subtitle') ? old('subtitle') : $category->subtitle }}">
            @error('subtitle')
                <div id="subtitleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-2">
            <label for="photo-file" class="form-label">Imagine</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="\storage\images\categories\{{ $category->image }}" class="img-thumbnail" alt="Imagine categorie">
                </div>
            <input class="form-control" type="file" accept="image/*" id="photo-file" name="image">
            @error('photo')
                <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-9">
            <label for="InputPresentation" class="form-label">Prezentare</label>
            <textarea type="text" class="form-control categoryTextArea @error('presentation') is-invalid @enderror" id="InputPresentation" aria-describedby="presentationHelp" name="presentation">{{ old('presentation') ? old('presentation') : $category->presentation }}</textarea>
            @error('presentation')
                <div id="presentationHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-1">
            <label for="InputPosition" class="form-label">Poziție</label>
            <input type="number" class="form-control @error('position') is-invalid @enderror" id="InputPosition" aria-describedby="positionHelp" name="position" value="{{ $category->position }}">
            @error('position')
                <div id="positionHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-1">
            <label for="Published" class="form-label">Publicat</label>
            <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ $category->published == 1 ? 'checked' : ''}}>
                <label class="form-check-label" for="flexCheckDefaultForPublished">Public</label>
            </div>
        </div>                        
        <div class="mb-3 row g-3">
            <div class="mb-3 col-md-4">
                <label for="InputMetaTitle" class="form-label">Meta Title</label>
                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="InputMetaTitle" aria-describedby="metaTitleHelp" name="meta_title" value="{{ old('meta_title') ? old('meta_title') : $category->meta_title }}">
                @error('meta_title')
                    <div id="MetaTitleHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="InputMetaDescription" class="form-label">Meta Description</label>
                <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="InputMetaDescription" aria-describedby="metaDescriptionHelp" name="meta_description" value="{{ old('meta_description') ? old('meta_description') : $category->meta_description }}">
                @error('meta_description')
                    <div id="MetaDescriptionHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="InputMetaKeywords" class="form-label">Meta Keywords</label>
                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="InputMetaKeywords" aria-describedby="metaKeywordsHelp" name="meta_keywords" value="{{ old('meta_keywords') ? old('meta_keywords') : $category->meta_keywords }}">
                @error('meta_keywords')
                    <div id="MetaKeywordsHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 mx-auto col-lg-3">
        <button type="submit" class="btn btn-primary">Editare categorie</button>
        </div>
    </form>      
    <br>
@endsection

@section('custom-js')
    @include('scripts.ckeditor-scripts')

    @include('scripts.image-preview-script')

    @include('scripts.slug-scripts')
@endsection