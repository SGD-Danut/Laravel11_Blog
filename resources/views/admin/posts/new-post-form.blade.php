@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)
 
@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>  
        @include('admin.template.parts.messages')   
    </div>
    <form action="{{ route('admin.create-new-post') }}" method="POST" class="mx-auto row g-3" enctype="multipart/form-data"> 
        @csrf
        <div class="mb-3 col-md-4">
            <label for="InputTitle" class="form-label">Nume</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="InputTitle" aria-describedby="titleHelp" name="title" value="{{ old('title') }}">
            @error('title')
                <div id="titleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="InputSlug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="InputSlug" aria-describedby="slugHelp" name="slug" value="{{ old('slug') }}">
            @error('slug')
                <div id="slugHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="InputSubtitle" class="form-label">Subtitlu</label>
            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="InputSubtitle" aria-describedby="subtitleHelp" name="subtitle" value="{{ old('subtitle') }}">
            @error('subtitle')
                <div id="subtitleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="InputPresentation" class="form-label">Prezentare</label>
            <textarea type="text" class="form-control postTextArea @error('presentation') is-invalid @enderror" id="InputPresentation" aria-describedby="presentationHelp" name="presentation" value="{{ old('presentation') }}"></textarea>
            @error('presentation')
                <div id="presentationHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="InputContent" class="form-label">Conținut</label>
            <textarea type="text" class="form-control postTextArea @error('content') is-invalid @enderror" id="InputContent" aria-describedby="contentHelp" name="content" value="{{ old('content') }}"></textarea>
            @error('content')
                <div id="contentHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-2">
            <label for="photo-file" class="form-label">Imagine</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="\storage\images\posts\post.png" class="img-thumbnail" alt="Imagine postare">
                </div>
            <input class="form-control" type="file" accept="image/*" id="photo-file" name="image">
            @error('image')
                <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-1">
            <label for="Published" class="form-label">Publicat</label>
            <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForPublished" name="published" {{ old('published') == 1 ? 'checked' : ''}}>
                <label class="form-check-label" for="flexCheckDefaultForPublished">Public</label>
            </div>
        </div>
        <div class="mb-3 col-md-2">
            <label for="InputPublicationDate" class="form-label">Dată publicare</label>
            <input type="date" class="form-control @error('published_at') is-invalid @enderror" id="InputPublicationDate" aria-describedby="publicationDateHelp" name="published_at" value="{{ old('published_at') ? old('published_at') : date('Y-m-d') }}">
            @error('published_at')
                <div id="PublicationDateHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        @if (isset($authors))
            <div class="mb-3 col-md-3">
            <label for="SelectPostAuthor" class="form-label">Autor</label>
            <select name="post_author" class="form-select" aria-label="SelectPostAuthor">
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="mb-3 row g-3">
            <div class="mb-3 col-md-4">
                <label for="InputMetaTitle" class="form-label">Meta Title</label>
                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="InputMetaTitle" aria-describedby="metaTitleHelp" name="meta_title" value="{{ old('meta_title') }}">
                @error('meta_title')
                    <div id="MetaTitleHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="InputMetaDescription" class="form-label">Meta Description</label>
                <input type="text" class="form-control @error('meta_description') is-invalid @enderror" id="InputMetaDescription" aria-describedby="metaDescriptionHelp" name="meta_description" value="{{ old('meta_description') }}">
                @error('meta_description')
                    <div id="MetaDescriptionHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-4">
                <label for="InputMetaKeywords" class="form-label">Meta Keywords</label>
                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="InputMetaKeywords" aria-describedby="metaKeywordsHelp" name="meta_keywords" value="{{ old('meta_keywords') }}">
                @error('meta_keywords')
                    <div id="MetaKeywordsHelp" class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 mx-auto col-lg-3">
        <button type="submit" class="btn btn-primary">Adaugă postare</button>
        </div>
    </form>    
    <br>
@endsection

@section('custom-js')
    @include('scripts.ckeditor-scripts')

    @include('scripts.image-preview-script')

    @include('scripts.slug-scripts')
@endsection