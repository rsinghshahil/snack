@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="text-align:center">
                    Meal of the Day
                @if(isset($meal->bmstatus))
                    @if($meal->bmstatus == 1)
                    (<b>open</b>)
                    @else
                    (<b>closed</b>)
                    @endif
                @endif
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8" style="padding-left:350px">
                                <h2 style="text-align:center">{{isset($meal->name) ? $meal->name : ''}}{{isset($total_cost) ? $total_cost : ''}}</h2>
                                <img src="{{isset($meal->image) ? $meal->image : ''}}" alt="meal" style="height:180px;width:350px">
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12 text-center">
                            @if($meal->bmstatus == 0)
                                <a aria-disabled="" class="btn btn-lg btn-primary justify-content-center"> Order no longer available</a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-lg btn-success justify-content-center"> Order Now</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
