@if (count($errors) > 0)
    <br>
    <ul class="list-group col-lg-10 mx-auto">
    @foreach($errors->all() as $error)
        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
    @endforeach
    </ul>
    <br>
@endif
@if (Session::has('success'))
    <br>
    <ul class="list-group col-lg-10 mx-auto">
        <div class="list-group-item list-group-item-success" role="alert">
            {!! Session::get('success') !!}
        </div>
    </ul>
    <br>
@endif
@if (Session::has('error'))
    <br>
    <ul class="list-group col-lg-10 mx-auto">
        <div class="list-group-item list-group-item-danger" role="alert">
            {!! Session::get('error') !!}
        </div>
    </ul>
    <br>
@endif
