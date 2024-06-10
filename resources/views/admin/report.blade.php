@extends('admin.layout')
@section('pages','Resep')
@section('content')
<h3>Report  Table</h3>
<div class="table-responsive">

    <table class="table  ">
        <thead>
            <tr>

                <th>Judul</th>

            </tr>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->community->title }}</td>
                


                </tr>

            @endforeach


        </thead>
    </table>
    @markdown()
    @endmarkdown
</div>
@endsection
