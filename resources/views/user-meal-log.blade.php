@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Your Meal Log
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <table class="table table-hover" id="logs">
                                <thead>
                                  <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Meal</th>
                                    <th>Image</th>
                                    <th>Cost</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $key => $item)
                                  <tr>
                                    <td>{{++ $key}}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                    <td><img src="{{isset($item->image) ? $item->image : ''}}" alt="meal" style="height:55px;width:80px;border-radius:10px"></td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->total_cost}}</td>
                                  </tr>
                                @endforeach
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function (){
        $('#logs').DataTable();
    })
</script>
@endsection
