@extends('front.template.master-page')

@section('head-title', $title)

@section('custom-css')
    <!-- Magnific Popup core CSS file -->
    <link href="/css/magnific-popup.css" rel="stylesheet" type="text/css" />
@endsection

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

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          {{ $post->publicImages()->links() }}
          <br>
          <div class="all-blog-posts">
            <div class="down-content">
              <span>Galerie Foto Postare</span>
              <h5>Galeria foto a acestei postări are {{ $post->publicImages()->total() }} imagini:</h5></a>
            </div>
            <div class="row">
              @forelse ($post->publicImages() as $image)
                <div class="col-lg-3">
                  <div class="blog-post">
                    <div class="popup-gallery blog-thumb">
                      <a href="{{ $image->imageUrl() }}" title="Imagine">
                        <img src="{{ $image->imageUrl() }}" alt="Gallery image">
                      </a>
                    </div>
                    <div class="down-content">
                      <a href="post-details.html"><h4>{{ $image->title }}</h4></a>
                      <p>{{ $image->description }}</p>
                    </div>
                  </div>
                </div>
              @empty
                <div class="col-lg-9">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="/storage/images/posts/photo-image-gallery-2.jpg" alt="">
                    </div>
                    <div class="down-content">
                      <span>Galerie Foto Postare</span>
                      <h4>Nu există imagini în galeria foto a acestei postări!</h4></a>
                    </div>
                  </div>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
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