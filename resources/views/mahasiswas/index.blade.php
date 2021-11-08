@extends('mahasiswas.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
        </div>
    </div>
</div>

<form class="form" method="get" action="{{ route('search') }}">
    <div class="form-group w-100 mb-3">
        <label for="search" class="d-block mr-2">Pencarian</label>
        <input type="text" name="search" class="form-control w-75 d-inline" id="search" placeholder="Masukkan keyword">
        <button type="submit" class="btn btn-primary mb-1">Cari</button>
    </div>
</form>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif



<table class="table table-bordered">
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>foto</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>No_Handphone</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($paginate as $Mahasiswa)
    <tr>
        <td>{{ $Mahasiswa->nim }}</td>
        <td>{{ $Mahasiswa->nama }}</td>
        <td><img src="{{asset('storage/'.$Mahasiswa->foto)}}" alt="" srcset="" height="100px" width="100px"></td>
        <td>{{ $Mahasiswa->kelas->nama_kelas }}</td>
        <td>{{ $Mahasiswa->jurusan }}</td>
        <td>{{ $Mahasiswa->no_handphone }}</td>
        <td>
            <form action="{{ route('mahasiswas.destroy',$Mahasiswa->nim) }}" method="POST">
                <a class="btn btn-info" href="{{route('mahasiswas.show',$Mahasiswa->nim) }}">Show</a>
                <a class="btn btn-primary" href="{{route('mahasiswas.edit',$Mahasiswa->nim) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
                <a class="btn btn-warning" href="{{route('mahasiswa.nilai',$Mahasiswa->nim)}}">Nilai</a>
            </form>
        </td>
    </tr>
    @endforeach
</table>

    {{ $paginate->links() }}
@endsection
