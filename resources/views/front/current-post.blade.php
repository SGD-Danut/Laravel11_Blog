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
            <h4>Postare:</h4>
            <h2>{{ $post->title }}</h2>
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
        <div class="col-lg-9">
          <div class="all-blog-posts">
            <div class="row">
              <div class="col-lg-12">
                <div class="blog-post">
                  <div class="blog-thumb">
                    <img src="/storage/images/posts/{{ $post->image }}" alt="">
                  </div>
                  <div class="down-content">
                    <span>Postare:</span>
                    <h4>{{ $post->title }}</h4>
                    <ul class="post-info">
                      @foreach ($post->publicCategories() as $category)
                        <li><a href="{{ route('front.current-category', $category->slug) }}">{{ $category->title }}</a></li>
                      @endforeach
                    </ul>
                    <br>
                    {!! $post->content !!}
                    <br>
                    <div class="post-options">
                      <div class="row">
                        <div class="col-6">
                          <ul class="post-tags">
                            <li><i class="fa fa-calendar"></i></li>
                            <li><a href="#">Actualizat la: {{ $post->updated_at->format('d.m.Y - H:i') }}</a></li>
                          </ul>
                        </div>
                        <div class="col-6">
                          <ul class="post-share">
                            <li><i class="fa fa-eye"></i></li>
                            <li><a href="#">Vizualizări: {{ $post->views }}</a></li>
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