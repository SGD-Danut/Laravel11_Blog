@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
        @include('admin.template.parts.messages')
        <br>
        @can('only-admin-and-author-have-rights')
            <a href="{{ route('admin.new-category-form') }}">
                <button type="button" class="btn btn-success new-category-button">Categorie nouă</button>
            </a>
        @endcan             
    </div>
    <table class="table" id="datatables">
        <thead>
            <tr>
                <th scope="col">Poziție:</th>
                <th scope="col">Titlu / Postări categorie:</th>
                <th scope="col">Subtitlu:</th>
                <th scope="col">Vizualizări:</th>
                <th scope="col" class="text-center">Imagine:</th>
                <th scope="col">Meta Desc / Key:</th>
                <th scope="col">Acțiuni:</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->position }}</td>
                    <td>
                        {{ $category->title }} <br>
                        <a href="{{ route('admin.posts', ['category' => $category->id]) }}">Postări ({{ $category->posts()->count() }})</a>
                    </td>                    
                    <td>{{ $category->subtitle }}</td>
                    <td>{{ $category->views }}</td>
                    <td><img src="/storage/images/categories/{{ $category->image }}" class="categoryImage mx-auto" width="40" alt="Imagine categorie"></td>
                    <td>
                        {{ $category->meta_description }} <br>
                        {{ $category->meta_keywords }}
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <a href="{{ route('admin.edit-category-form', $category->id) }}"><button type="button" class="btn btn-primary">Editare</button></a>
                                @can('only-admin-and-author-have-rights')
                                <form id="delete-category-form-with-id-{{ $category->id }}" action="{{ route('admin.delete-category', $category->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button type="button" class="btn btn-danger" onclick="
                                if(confirm('Sigur ștergeți categoria: {{ $category->title }}?')) {
                                    document.getElementById('delete-category-form-with-id-' + {{ $category->id }}).submit();
                                }
                                ">Ștergere</button>
                            @endcan
                        </div>
                    </td>        
                </tr>
            @endforeach
        </tbody>
    </table>    
@endsection