@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        @include('admin.template.parts.messages')
        <br>
        <a href="{{ route('admin.new-category-form') }}">
            <button type="button" class="btn btn-success new-category-button">Categorie nouă</button>
        </a>             
    </div>
    <table class="table" id="datatables">
        <thead>
            <tr>
                <th scope="col">Titlu:</th>
                <th scope="col">Subtitlu:</th>
                <th scope="col">Vizualizări:</th>
                <th scope="col" class="text-center">Imagine:</th>
                <th scope="col">Meta Desc / Key:</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->subtitle }}</td>
                    <td>{{ $category->views }}</td>
                    <td><img src="/storage/images/categories/{{ $category->image }}" class="categoryImage mx-auto" width="40" alt="Imagine categorie"></td>
                    <td>
                        {{ $category->meta_description }} <br>
                        {{ $category->meta_keywords }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>    
@endsection