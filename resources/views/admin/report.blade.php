@extends('admin.layout')
@section('pages','Resep')
@section('content')
<h3>Report  Table</h3>
<div class="table-responsive">

    <table class="table  ">
        <thead>
            <tr>

                <th>Judul</th>
                <th>Aksi</th>
            </tr>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->community->title }}</td>
                    <td><a class="btn btn-danger" href="{{route('report.delete',$report->id)}}">Delete</a></td>
                </tr>

            @endforeach


        </thead>
    </table>
    @markdown()
    @endmarkdown
</div>
@endsection
