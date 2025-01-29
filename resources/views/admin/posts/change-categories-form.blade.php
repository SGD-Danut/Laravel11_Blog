@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    {{-- Margini form custom: --}}
    <style>
        form {
            margin-left: 50px;
            margin-right: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title . ' pentru postarea: ' . $post->title }}</h5>  
        @include('admin.template.parts.messages')   
    </div>
    <form action="{{ route('admin.change-categories', $post->id) }}" method="POST">
        @csrf
        @method('put')
        @foreach ($categories as $category)
        <div class="mb-3">
            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="check-{{ $category->id }}" name="categories[]" {{ $post->categories()->find($category->id) ? 'checked' : ''}}>
            <label class="form-check-label" for="check-{{ $category->id }}">
                {{ $category->title }}
            </label>
        </div>    
        @endforeach
        <div class="mb-3 mx-auto col-lg-3">
            <button type="submit" class="btn btn-primary">Schimbare categorii postare</button>
        </div>
    </form>    
    <br>
@endsection