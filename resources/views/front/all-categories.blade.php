@extends('front.template.master-page')

@section('head-title', $title)

@section('categories')
<div class="main-banner header-text">
    <div class="container-fluid">
      <div class="owl-banner owl-carousel">
          @foreach ($categories as $category)
                <div class="item">
                    <img src="/storage/images/categories/{{$category->image  }}" alt="">
                    <div class="item-content">
                    <div class="main-content">
                        <div class="meta-category">
                            <span>Categorie:</span>
                        </div>
                        <a href="{{ route('front.current-category', $category->slug) }}"><h4>{{ $category->title }}</h4></a>
                        <ul class="post-info">
                            <li><a href="#">Admin</a></li>
                            <li><a href="#">Numar Postări</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
          @endforeach
      </div>
    </div>
</div>
@endsection