<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Artikel</h4>
	</center>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Judul</th>
				<th>Isi</th>
				<th>Gambar</th>
			</tr>
		</thead>
		<tbody>
			@foreach($articles as $a)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{$a->title}}</td>
                <td>{{$a->content}}</td>
				<td>{{$a->featured_image}}</td>
                {{-- <td><img src="{{asset('storage/'.$a->featured_image)}}" alt="" srcset="" width="100px" height="100px"></td> --}}
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
