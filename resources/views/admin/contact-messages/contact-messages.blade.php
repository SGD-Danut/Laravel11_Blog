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
    </div>
    <table class="table table-hover my-0" id="datatables">
        <thead>
            <tr>
                <th class="d-none d-xl-table-cell">Nume:</th>
                <th class="d-none d-xl-table-cell">Email:</th>
                <th class="d-none d-xl-table-cell">Categorie:</th>
                <th scope="col" class="text-center">Mesaj:</th>
                <th class="d-none d-md-table-cell">Trimis la:</th>
                <th scope="col">Acțiuni:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactMessages as $contactMessage)
                <tr>
                    <td class="d-none d-xl-table-cell">{{ $contactMessage->name }}</td>
                    <td class="d-none d-xl-table-cell">{{ $contactMessage->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $contactMessage->category }}</td>
                    <td class="d-none d-xl-table-cell">{{ $contactMessage->message }}</td>
                    <td class="d-none d-md-table-cell">{{ $contactMessage->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <form id="delete-contact-message-form-with-id-{{ $contactMessage->id }}" action="{{ route('admin.delete-contact-message', $contactMessage->id) }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            <button type="button" class="btn btn-danger" onclick="
                            if(confirm('Sigur ștergeți acest mesaj?')) {
                                document.getElementById('delete-contact-message-form-with-id-' + {{ $contactMessage->id }}).submit();
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