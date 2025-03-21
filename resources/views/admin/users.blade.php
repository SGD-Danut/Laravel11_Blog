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
        @include('admin.template.parts.messages')
        <br>
        <a href="{{ route('new-user-form') }}">
            <button type="button" class="btn btn-success new-user-button">Utilizator nou</button>
        </a>      
    </div>
    <table class="table table-hover my-0" id="datatables">
        <thead>
            <tr>
                <th>#</th>
                <th class="d-none d-xl-table-cell">Verificat:</th>
                <th class="d-none d-xl-table-cell">Nume:</th>
                <th class="d-none d-xl-table-cell">Email:</th>
                <th class="d-none d-xl-table-cell">Adresa / Telefon:</th>
                <th scope="col" class="text-center">Fotografie:</th>
                <th class="d-none d-xl-table-cell">Rol:</th>
                <th class="d-none d-md-table-cell">Creat la:</th>
                <th scope="col">Acțiuni:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td scope="row">{!! $user->hasVerifiedEmail() ? '<i class="bi bi-person-check-fill text-info"> Da</i>' : '<i class="bi bi-person-check text-warning"> Nu</i>' !!}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->name }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->address }} {{ $user->phone }}</td>
                    <td><img src="/storage/images/users/{{ $user->photo }}" class="mx-auto" width="35" alt="Imagine utilizator"></td>
                    <td class="d-none d-xl-table-cell">
                        @if ($user->role == 'author')
                            <a href="{{ route('admin.posts', ['author' => $user->id]) }}" title="Vezi postări utilizator">{{ $user->role }} ({{ $user->posts->count() }})</a>
                        @else
                            {{ $user->role }}
                        @endif
                    </td>
                    <td class="d-none d-md-table-cell">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <a href="{{ route('edit-user-form', $user->id) }}"><button type="button" class="btn btn-primary">Editare</button></a>
                            <form id="delete-user-form-with-id-{{ $user->id }}" action="{{ route('delete-user', $user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            <button type="button" class="btn btn-danger" onclick="
                            if(confirm('Sigur ștergeți acest utilizator?')) {
                                document.getElementById('delete-user-form-with-id-' + {{ $user->id }}).submit();
                            }
                            ">Ștergere</button>
                        </div>
                    </td>                                      
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $("#datatables").DataTable({
                oLanguage: {
                    sSearch: "Cauta utilizatori:"
                },
                language: {
                    info: "Se afiseaza pagina _PAGE_ din _PAGES_",
                    infoFiltered: "(filtrat din _MAX_ intrări)",
                    lengthMenu: "Afiseaza _MENU_ randuri / pagina",
                    paginate: {
                        next: "Urm",
                        first: "Prima",
                        last: "Ultima",
                        previous: "Prec"
                    }
                }
            });
        });
    </script>
@endsection