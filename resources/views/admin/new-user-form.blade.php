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
    <form action="{{ route('create-new-user') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="InputName" class="form-label">Nume complet</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="InputName" aria-describedby="nameHelp" name="name" value="{{ old('name') }}">
            @error('name')
                <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputEmail" class="form-label">Adresă de email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="InputEmail" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputAddress" class="form-label">Adresă</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="InputAddress" aria-describedby="addressHelp" name="address" value="{{ old('address') }}">
            @error('address')
                <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputPhone" class="form-label">Nr. telefon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="InputPhone" aria-describedby="phoneHelp" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="SelectRole" class="form-label">Rol</label>
            <select class="form-select" aria-label="Select role" name="role" value="{{ old('role') }}">
                <option value="admin">Administrator</option>
                <option value="author" selected>Autor</option>
                <option value="editor">Editor</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="InputPassword" class="form-label">Parolă</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="InputPassword" name="password">
            @error('password')
            <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputConfirmPassword" class="form-label">Confirmare parolă</label>
            <input type="password" class="form-control" id="InputConfirmPassword" name="password_confirmation">
        </div>
        <div class="mb-3">
            <label for="photo-file" class="form-label">Fotografie</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="\storage\images\users\defaultUserPhoto.png" class="img-thumbnail mx-auto d-block" alt="Imagine utilizator" width="150">
                </div>
            <input class="form-control" type="file" accept="image/*" id="photo-file" name="photo">
            @error('photo')
                <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>                
        <button type="submit" class="btn btn-primary">Adaugă utilizator</button>
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