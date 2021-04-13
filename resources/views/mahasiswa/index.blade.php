@extends('mahasiswa.layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-10">
                    <form action="{{ route('mahasiswa.search') }}" method="GET">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                    aria-describedby="keywords" placeholder="Masukkan nama mahasiswa">
                                <span class="input-group-btn ml-3">
                                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 ml-auto">
                    <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
                </div>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Photo</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mahasiswas as $mahasiswa)
            <tr>
                <td>
                    @php
                        $pathImage = '';
                        $mahasiswa->photo ? ($pathImage = 'storage/' . $mahasiswa->photo) : ($pathImage = 'img/empty.jpg');
                    @endphp
                    <img src="{{ asset('' . $pathImage . '') }}" width="100" alt="">
                </td>
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
                        <a class="btn btn-warning" href="{{ route('mahasiswa.nilai', $mahasiswa->nim) }}">Nilai</a>
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
