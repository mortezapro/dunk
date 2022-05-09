@extends("User.Dashboard.Layouts")
@section("head")
    <title>درخواست تبدیل سکه به پول</title>
    <meta name="description" content="">
@endsection
@section("content")



    
    <div class="row back-table">
         <div class="col-lg-12 col-sm-12">
            <h3 class="page-header">درخواست تبدیل سکه به پول </h3>
        </div>
            <div class="col-lg-5 col-sm-9 change-coin mrgb50">
    <form method="post" action="{{route("changeCoinSubmitRoute")}}" enctype="multipart/form-data">
        @csrf
        

        <div class="col-lg-12 col-sm-12">
            <span id="total" class="col-lg-5 col-sm-4" style="padding: 5px 5px !important;
    margin-top: 26px;
    background: #00800061;
    border-radius: 5px;">*</span>
           <div class="form-group  col-lg-7 col-sm-8">
               <label for=""> تعداد سکه</label>
               <input type="text" placeholder="" name="coin" id="coin" class="form-control" value="" onkeyup="priceCoin();">
           </div>
           
      
        </div>
        <input type="hidden" placeholder="" name="user" class="form-control" value="{{$user_id}}">
        <input type="hidden" placeholder="" name="price" id="price" class="form-control" value="{{$price_coin}}">

       
 
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary" style="margin-top:15px">ثبت</button>
        </div>
    </form>
    </div>

        
        
        <div class="col-lg-12">
            <h3 class="page-header">درخواست های من </h3>
        </div>
        <div class="col-lg-12">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>تعداد سکه </td>
                        <td>تاریخ درخواست </td>
                        <td>وضعیت</td>
                    </tr>
                </thead>
                <tbody>
                @php $i=0; @endphp
                @foreach($user_coins as $user_coin)
                    @php $i++; @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$user_coin->request_coin}}</td>
                        <td>{{\Morilog\Jalali\Jalalian::forge($user_coin->request_date)->format('%d')}} {{\Morilog\Jalali\Jalalian::forge($user_coin->request_date)->format('%B')}}</td>
                        <td>@php if ($user_coin->request_state==0)echo  "در حال بررسی";if ($user_coin->request_state==1) echo "تایید شده " ; if ($user_coin->request_state==2) echo "ارسال شده";  @endphp</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        
         <div id="pagination">
                {{ $user_coins->links() }}
         </div>
    </div>
<style>
    .mrgt-right
    {
        float:right;
        margin-right:20%;
    }
    .change-coin
    {
        box-shadow: 0 0 5px 2px #bab9b9;
    padding: 20px !important;
    float: right;
    margin-right: 20%;
    background: #f1f1f1;
    margin-top:15px;
    border-radius:10px;
    }
    .mrgb50{
        margin-bottom:50px;
        display:block;
    }

</style>
<script>
    function priceCoin()
    {
        var price = document.getElementById("price").value;
        var coin = document.getElementById("coin").value;
        var total = price * coin;
        document.getElementById("total").innerHTML = "قیمت(تومان): " + total;
    }
</script>


@endsection
