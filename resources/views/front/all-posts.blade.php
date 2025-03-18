@extends('front.template.master-page')

@section('current-page-name')
<!-- Banner Starts Here -->
<div class="heading-page header-text">
  <section class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-content">
            <h4>Toate Postările:</h4>
            <h2></h2>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Banner Ends Here -->
@endsection

@section('posts')
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="all-blog-posts">
                        <div class="row">
                            @isset($allPostsTitle)
                                @include('front.components.posts-list', ['pages' => $posts, 'title' => $allPostsTitle])         
                            @endisset
                            @isset($author)
                                @include('front.components.posts-list', ['pages' => $posts, 'title' => $author])
                            @endisset
                            @isset($searchPostTerm)
                              @include('front.components.posts-list', ['pages' => $posts, 'title' => $searchPostTerm])
                            @endisset
                        </div>
                    </div>
                </div>
                {{-- Side Nav: --}}
        @include('front.side-nav')
            </div>
        </div>
    </section>
@endsection