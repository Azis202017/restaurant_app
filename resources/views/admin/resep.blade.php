@extends('admin.layout')
@section('pages','Resep')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
















e               </tr>
        </thead>
        <tbody>
            @foreach ($reseps as $resep)
            <tr>
                <td>{{ $resep->judul_resep }}</td>
                <td>
                    <form action="{{ route('update_status', ['id' => $resep->id]) }}" method="POST" class="d-flex">
                        @csrf
                        <select name="status" class="form-control" required>
                            <option value="diajukan" {{ $resep->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="ditolak" {{ $resep->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="dipublikasikan" {{ $resep->status == 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
                        </select>
                        <button class="btn btn-success ms-2" type="submit">Simpan</button>
                    </form>
                </td>
                <td><a href="{{ route('resep.delete', $resep->id) }}" class="btn btn-danger">Delete</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
