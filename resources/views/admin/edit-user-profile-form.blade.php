@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    {{-- Margini tabel datatables CSS custom: --}}
    <style>
        #datatables_wrapper {
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>     
    </div>
    <form action="{{ route('update-user-profile') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="InputName" class="form-label">Nume complet</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="InputName" aria-describedby="nameHelp" name="name" value="{{ $user->name }}">
            @error('name')
                <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputEmail" class="form-label">Adresă de email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="InputEmail" aria-describedby="emailHelp" name="email" value="{{ $user->email }}">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputAddress" class="form-label">Adresă</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="InputAddress" aria-describedby="addressHelp" name="address" value="{{ $user->address }}">
            @error('address')
                <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputPhone" class="form-label">Nr. telefon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="InputPhone" aria-describedby="phoneHelp" name="phone" value="{{ $user->phone }}">
            @error('phone')
                <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="photo-file" class="form-label">Fotografie</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="{{ '/storage/images/users/' . $user->photo }}" class="img-thumbnail mx-auto d-block" alt="Imagine utilizator" width="150">
                </div>
            <input class="form-control" type="file" accept="image/*" id="photo-file" name="photo">
            @error('photo')
                <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizare profil utilizator</button>
    </form>
    <br>
    @if(Session::has('passwordMessage'))
        <div class="col-lg-3 mx-auto">
            <div class="text-success" role="alert">
                {!! Session::get('passwordMessage') !!}
            </div>
        </div>     
    @endif
    <form action="{{ route('update-password') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data" id="change-password-form">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="InputPassword" class="form-label">Parolă actuală</label>
            <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="InputPassword" name="old_password">
            @error('old_password')
                <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
            </div>
        <div class="mb-3">
            <label for="InputPassword" class="form-label">Noua parolă</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="InputPassword" name="new_password">
            @error('new_password')
            <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputConfirmPassword" class="form-label">Confirmare noua parolă</label>
            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="InputConfirmPassword" name="new_password_confirmation">
            @error('new_password_confirmation')
                <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Schimbare parolă</button>
    </form>       
    <br>
@endsection

@section('custom-js')
    <script>
        const chooseFile = document.getElementById("photo-file");
        const imgPreview = document.getElementById("image-preview");

        chooseFile.addEventListener("change", function () {
            getImgData();
        });

        function getImgData() {
            const file = chooseFile.files[0];
            if (file) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.addEventListener("load", function () {
                    imgPreview.style.display = "block";
                    imgPreview.innerHTML = '<img src="' + this.result + '" class="img-thumbnail" alt="Imagine utilizator">';
                });    
            }
        }
    </script>
@endsection