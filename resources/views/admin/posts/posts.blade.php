@extends('admin.template.master-page')

@section('head-title', $title)

{{-- Metoda 1: --}}
{{-- @if (!request('author'))
    @section('big-title', $title)
@else
    @if (request('author'))
        @section('big-title')
            {{ $title . ':' . ' ' . $posts[0]->author->name }}
        @endsection
    @endif
@endif --}}

{{-- Metoda 2: --}}
@if (!isset($authorName))
    @section('big-title', $title)
@else
    @if (isset($authorName))
        @section('big-title')
            {{ $title . ':' . ' ' . $authorName }}
        @endsection
    @endif
@endif

@section('content')
    <style>
        .sortable {
            min-width: 170px;
        }
    </style>
    <div class="card-header">
        <h5 class="card-title mb-0">
            @if (isset($postsStatus))
                {{ $title . ' ' . $postsStatus }} 
            @else
                {{ $title }}
            @endif
        </h5>
        @include('admin.template.parts.messages')
        <br>           
    </div>
    <div class="card">
        <div class="text-center">
            <div class="mb-3">
                <a class="btn btn-primary" href="{{ route('admin.posts') }}">Toate</a>
                <a class="btn btn-success" href="{{ route('admin.posts', ['published' => 'public']) }}">Publicate</a>
                <a class="btn btn-warning" href="{{ route('admin.posts', ['published' => 'private']) }}">Nepublicate</a>
            </div>
        </div>
    </div>
    @if ($posts->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><a href="{{ route('admin.posts') }}"><i class="fa-solid fa-file-lines"></i></a></th>
                    <th scope="col" class="sortable">@sortablelink('title', 'Titlu') / @sortablelink('created_at', 'Creat la:')</th>
                    <th scope="col">Autor:</th>
                    <th scope="col" class="text-center">Imagine:</th>
                    <th scope="col" class="sortable">@sortablelink('views', 'Vizualizări:')</th>
                    <th scope="col">Meta Desc / Key:</th>
                    {{-- <th scope="col">Acțiuni:</th> --}}
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($posts as $post)
                    <tr class="{{-- {{ $post->published_at != null ? 'bg-light' : 'bg-warning' }} --}}">
                        <td>
                            @if (isset($post->published_at))
                                <a href="{{ route('admin.posts', ['published' => 'public']) }}"><i class="fa-solid fa-file-lines text-success"></i></a>
                            @else
                                <a href="{{ route('admin.posts', ['published' => 'private']) }}"><i class="fa-solid fa-file-lines text-warning"></i></a>
                            @endif
                        </td>                                
                        <td>{{ $post->title }} <br> {{ $post->created_at->format('d.m.Y - H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.posts', ['author' => $post->author->id]) }}">
                            {{ $post->author->name }} ({{ $post->author->posts->count() }})
                            </a>
                        </td>
                        
                        <td><img src="/storage/images/posts/{{ $post->image }}" class="postImage mx-auto" width="40" alt="Imagine postare"></td>
                        <td>{{ $post->views }}</td>
                        <td>
                            {{ $post->meta_description }} <br> {{ $post->meta_keywords }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    @else
        <div class="alert alert-warning"><h5>Acest utilizator nu are nici-o postare!</h5></div>
    @endif
@endsection