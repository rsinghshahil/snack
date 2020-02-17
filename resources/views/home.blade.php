@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Meal of the Day
                @if(isset($data->status))
                    @if($data->status == 1)
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
                        <div class="col-md-12 text-center">
                            <div class="col-md-12 ">
                                <h2>{{isset($data->name) ? $data->name : ''}}{{isset($total_cost) ? $total_cost : ''}}</h2>
                                <img src="{{isset($data->image) ? $data->image : ''}}" alt="meal" style="height:180px;width:350px">
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <form class="rating" data-mid="{{$data->meal_id}}">
                                    {{ csrf_field() }}
                                    <label>
                                      <input type="radio" name="stars" value="1" {{isset($rating) && $rating->rating == 1 ? 'checked' : ''}} />
                                      <span class="icon">★</span>
                                    </label>
                                    <label>
                                      <input type="radio" name="stars" value="2" {{isset($rating) && $rating->rating == 2 ? 'checked' : ''}} />
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                    </label>
                                    <label>
                                      <input type="radio" name="stars" value="3" {{isset($rating) && $rating->rating == 3 ? 'checked' : ''}} />
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                    </label>
                                    <label>
                                      <input type="radio" name="stars" value="4" {{isset($rating) && $rating->rating == 4 ? 'checked' : ''}} />
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                    </label>
                                    <label>
                                      <input type="radio" name="stars" value="5" {{isset($rating) && $rating->rating == 5 ? 'checked' : ''}} />
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                      <span class="icon">★</span>
                                    </label>
                                  </form>
                                <br>
                                <form action="{{route('orders.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="meal_status" value="{{$data->status}}">
                                    <input type="hidden" name="meal_id" value="{{$data->meal_id}}">
                                    <div class="form-group">
                                        <label for=""><b>Bread preferences</b></label>
                                        <select class="form-control" name="bread" id="bread">
                                            <option value="" disabled selected>Select Bread Type</option>
                                            @foreach ($breadtypes as $item)
                                                <option value="{{$item->id}}" {{isset($has_previous_order) && $has_previous_order->bread_type == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h4>Baked or Not Baked</h4>
                                        <input type="radio" name="baked" value="101" {{isset($has_previous_order) && $has_previous_order->non_baked == '101' ? 'checked' : '' }}> Baked
                                        <input type="radio" name="baked" value="100" {{isset($has_previous_order) && $has_previous_order->non_baked == '100' ? 'checked' : '' }} style="margin-left:2em"> Not Baked<br>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Bread size</b></label>
                                        <select class="form-control" name="bread_size" id="bread_size">
                                            <option value="" disabled selected>Select Bread Size</option>
                                            @foreach ($breadsizes as $item)
                                                <option value="{{$item->id}}" {{isset($has_previous_order) && $has_previous_order->bread_size == $item->id ? "selected" : "" }}>{{$item->size}} cm</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Taste preferance</b></label>
                                        <select class="form-control" name="taste_preference" id="taste_preference">
                                            <option value="" disabled selected>Select your taste preference</option>
                                            @foreach ($flavours as $item)
                                                <option value="{{$item->id}}" {{isset($has_previous_order) && $has_previous_order->flavour == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Extra's</b></label>
                                        <select class="form-control" name="extras" id="extras">
                                            <option value="" disabled selected>Extra for your hunger</option>
                                            <option value="100" {{isset($has_previous_order) && $has_previous_order->extras == "100" ? "selected" : "" }}> Extra Bacon</option>
                                            <option value="200" {{isset($has_previous_order) && $has_previous_order->extras == "200" ? "selected" : "" }}> Double Meal</option>
                                            <option value="300" {{isset($has_previous_order) && $has_previous_order->extras == "300" ? "selected" : "" }}> Extra Cheese</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Vegitables</b></label>
                                        <select class="form-control" name="vegetable" id="vegetables">
                                            <option value="" disabled selected>Select your vegies</option>
                                            @foreach ($vegetables as $item)
                                                <option value="{{$item->id}}" {{isset($has_previous_order) && $has_previous_order->vegetable == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Sauce</b></label>
                                        <select class="form-control" name="sauce" id="sauce">
                                            <option value="" disabled selected>Select your favourite sauce</option>
                                            @foreach ($sauces as $item)
                                                <option value="{{$item->id}}" {{isset($has_previous_order) && $has_previous_order->sauce == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <button type="submit" {{ $data->status != 1 ? "disabled" : "" }} class="btn btn-lg btn-block btn-success">Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function (){
        $(':radio').change(function() {
            let meal_id = $('.rating').data('mid');
            let rating = this.value;
            let data = {
                'meal_id': meal_id,
                'rating' : rating
            }
            console.log('New star rating: ' + rating);

            //call the ajax here
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url: '/rating',
                type: 'POST',
                data: data,
                success:function(data){
                    alert(data);
                },
                error: function(){
                    console.log('error');
                },
            });
        });
    })
</script>
@endsection
