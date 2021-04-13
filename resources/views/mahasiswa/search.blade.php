@extends('mahasiswa.layout')
@section('content')
    <div class="row my-3">
        <div class="col">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mahasiswas as $mahasiswa)
            <tr>
                <td>{{ $mahasiswa->nim }}</td>
                <td>{{ $mahasiswa->nama }}</td>
                <td>{{ $mahasiswa->kelas->nama_kelas }}</td>
                <td>{{ $mahasiswa->jurusan }}</td>
                <td>{{ $mahasiswa->no_handphone }}</td>
                <td>
                    <form action="{{ route('mahasiswa.destroy', $mahasiswa->nim) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('mahasiswa.show', $mahasiswa->nim) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('mahasiswa.edit', $mahasiswa->nim) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="row">
        <div class="col-12 text-center">
            {{ $mahasiswas->links() }}
        </div>
    </div>
@endsection
