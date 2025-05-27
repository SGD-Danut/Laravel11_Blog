<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="{{ route('front.all-categories') }}"><h2>Blog<em>.</em></h2></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('front.all-categories') }}">Categorii
            <span class="sr-only">(current)</span>
          </a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="{{ route('front.all-posts', ['posts' => 'all']) }}">{{ __('All posts') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('front.contact') }}">Contact</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="blog.html">Blog Entries</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="post-details.html">Post Details</a>
        </li> --}}
      </ul>
    </div>
  </div>
</nav>