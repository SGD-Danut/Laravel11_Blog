@extends('front.template.master-page')

@section('head-title', $title)

@section('current-page-name')
<!-- Banner Starts Here -->
<div class="heading-page header-text">
  <section class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-content">
            <h4>Categorie:</h4>
            <h2>{{ $category->title }}</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Banner Ends Here -->
@endsection

@section('content')
<section class="blog-posts grid-system">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="all-blog-posts">
            <div class="row">
              <div class="col-lg-12">
                <div class="blog-post">
                  <div class="blog-thumb">
                    <img src="/storage/images/categories/{{ $category->image }}" alt="">
                  </div>
                  <div class="down-content">
                    <span>Categorie:</span>
                    <h4>{{ $category->title }}</h4>
                    <ul class="post-info">
                      <li><a href="#">10 Postări</a></li>
                    </ul>
                    {!! $category->presentation !!}
                    <div class="post-options">
                      <div class="row">
                        <div class="col-6">
                          <ul class="post-tags">
                            <li><i class="fa fa-calendar"></i></li>
                            <li><a href="#">Actualizat la: {{ $category->updated_at->format('d.m.Y - H:i') }}</a></li>
                          </ul>
                        </div>
                        <div class="col-6">
                          <ul class="post-share">
                            <li><i class="fa fa-eye"></i></li>
                            <li><a href="#">Vizualizări: {{ $category->views }}</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              
            </div>
          </div>
        </div>
        {{-- Side Nav: --}}
        @include('front.side-nav')
      </div>
    </div>
</section>
@endsection