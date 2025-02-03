{{-- Listă postări ==> --}}
<div class="col-lg-12">
    <div class="blog-post">
      <div class="blog-thumb">
        <h3>{{ $title }}</h3>
        {{-- Pagination --}}
        <br>
        {{ $pages->links() }}
      </div>
    </div>
</div>
@foreach ($pages as $post)
    <div class="col-lg-6">
      <div class="blog-post">
        <div class="blog-thumb">
          <img src="/storage/images/posts/{{ $post->image }}" alt="Imagine postare {{ $post->slug }}" title="{{ $post->meta_description }}">
        </div>
        <div class="down-content">
          <span>{{ $post->title }}</span>
          <a href="post-details.html"><h4>{{ $post->subtitle }}</h4></a>
          <ul class="post-info">
            <li><a href="{{ route('front.all-posts', ['author' => $post->author->id]) }}">{{ $post->author->name }}</a></li>
            <li><a href="#">{{ $post->published_at->format('d.m.Y - H:i') }}</a></li>
            <li><a href="#">12 Commentarii</a></li>
          </ul>
          <p>{{ $post->presentation }}</p>
          <div class="post-options">
            <div class="row">
              <div class="col-lg-12">
                <ul class="post-tags">
                  <li><i class="fa fa-eye"></i></li>
                  <li><a href="#">Vizualizări: </a>{{ $post->views }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endforeach
<div class="col-lg-12">
    <div class="blog-post">
      <div class="blog-thumb">
        {{-- Pagination --}}
        <br>
        {{ $pages->links() }}
      </div>
    </div>
</div>
{{-- <== Listă postări --}}