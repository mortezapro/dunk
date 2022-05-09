@extends('Front.Layouts')
@section('main')
    <!--shipping----------------------------------->
    <div class="container-main">
        <div class="col-lg-12">
            <div class="col-lg-8 col-md-8 col-xs-12 pull-right">
                <div class="shipment-page-container">
                    <section class="page-content">
                        <div class="payment">
                            <form method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                            <div class="payment-payment-types">
                                @php $i=0 @endphp
                                @foreach($questions as $question)
                                    @php $i++ @endphp
                                    <div id="each@php echo $i-1 @endphp"></div>
                                <div class="payment-header">
                                        <span>
                                            {{$i.".".$question->question_text}}
                                        </span>
                                </div>
                                <ul class="payment-paymethod">
                                    <li>
                                        <div class="payment-paymethod-item">
                                            <label for="#" class="outline-radio">
                                                <input type="radio" name="answer{{$i}}" id="payment-option-online" value="{{$question->gozineh1}}">
                                                <span class="outline-radio-check"></span>
                                            </label>
                                            <label for="#" class="payment-paymethod-title-row">
                                                <div class="payment-paymethod-title">{{$question->gozineh1}}</div>
                                            </label>
                                        </div>
                                        <div class="payment-paymethod-item">
                                            <label for="#" class="outline-radio">
                                                <input type="radio" name="answer{{$i}}" id="payment-option-online" value="{{$question->gozineh2}}">
                                                <span class="outline-radio-check"></span>
                                            </label>
                                            <label for="#" class="payment-paymethod-title-row">
                                                <div class="payment-paymethod-title">{{$question->gozineh2}}</div>
                                            </label>
                                        </div>
                                        <div class="payment-paymethod-item">
                                            <label for="#" class="outline-radio">
                                                <input type="radio" name="answer{{$i}}" id="payment-option-online" value="{{$question->gozineh3}}">
                                                <span class="outline-radio-check"></span>
                                            </label>
                                            <label for="#" class="payment-paymethod-title-row">
                                                <div class="payment-paymethod-title">{{$question->gozineh3}}</div>
                                            </label>
                                        </div>
                                        <div class="payment-paymethod-item">
                                            <label for="#" class="outline-radio">
                                                <input type="radio" name="answer{{$i}}" id="payment-option-online" value="{{$question->gozineh4}}">
                                                <span class="outline-radio-check"></span>
                                            </label>
                                            <label for="#" class="payment-paymethod-title-row">
                                                <div class="payment-paymethod-title">{{$question->gozineh4}}</div>
                                            </label>
                                        </div>
                                        <input type="hidden" value="{{$question->question_id}}" name="master{{$i}}">
                                        <input type="hidden" value="{{$question->question_text}}" name="qt{{$i}}">
                                        <div class="correct correct@php echo $i-1 @endphp">جواب صحیح:
                                            <span class="answer-response@php echo $i-1 @endphp"></span>
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                                <input type="hidden" value="{{$quiz->quiz_id}}" name="quiz">
                            <div class="payment-voucher">
                                <div class="payment-voucher-header" id="btn-end">
                                    <button
                                        id="btn-end-quiz"
                                        class="btn btn-block text-right" type="submit">
                                        پایان آزمون
                                    </button>
                                    <button
                                        hidden
                                        id="btn-end-loader"
                                        class="btn btn-block text-right" type="button">
                                        <i class="fa fa-refresh fa-spin" style="color: white;margin-right: 0;"></i>
                                        در حال بررسی...
                                    </button>
                                </div>
                            </div>
                            </form>
                            <div id="cover-spin">
                                <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                                </svg>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                <div class="page-aside">
                    <div class="checkout-aside">
                        <div class="checkout-bill">
                            <ul class="checkout-bill-summary">
                                <li>
                                    <span class="checkout-bill-item-title" style="color: #62666d">نام آزمون:</span>
                                    <span class="checkout-bill-price">
                                            {{$quiz->quiz_name}}
                                        </span>
                                </li>
                                <li>
                                    <span class="checkout-bill-item-title" style="color: #62666d">تعداد سوال:</span>
                                    <span class="checkout-bill-item-title js-free-shipping">{{count($questions)}}</span>
                                </li>
                                <li class="checkout-bill-total-price">
                                    <span class="checkout-bill-total-price-title" style="color: #62666d">زمان باقی مانده:</span>
                                    <div class="parent-btn">
                                        <button class="dk-btn dk-btn-info payment-link">
                                            <span id="time" style="font-size: 18px;">{{$countdown}}</span>
                                            <i class="mdi mdi-clock"></i>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                            <div class="checkout-bill-digiclub" id="div_coin">
                                <span class="wiki-holder" id="text">جایزه:</span>
                                <span class="checkout-bill-digiclub-point" id="coin">
                                        {{$quiz->quiz_score}}
                                        <span class="checkout-bill-currency">
                                            سکه
                                        </span>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="winModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <!-- Modal content-->
                    <div class="modal-content" style="text-align: center">
                        <div class="modal-body">
                            <div id="win-user" style="">
                                <div id="m-score" class="col-lg-12" style="">
                                    <span  class="win-user">
                                        تبریک شما برنده ی
                                        <span id="score-user"></span>
                                        <span>سکه شدید</span>
                                    </span>
                                </div>
                                <img src="{{asset("images/gifts/bomb-gift.gif")}}" class="win-gif" style="width:360px"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{route("rewardRoute")}}"><button id="btn-end-win" type="button" class="btn btn-red">ورود به صفحه جایزه ها</button></a>
                            <a href="{{route("indexRoute")}}"><button id="btn-end-win" type="button" class="btn btn-red safe-coin">سکه هایم را ذخیره کن</button></a>
                            <button id="btn-end-win" type="button" data-dismiss="modal" style="margin-top: 15px;" class="btn btn-red">مشاهده جواب های صحیح</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lowModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <!-- Modal content-->
                    <div class="modal-content" style="text-align: center;">
                        <div class="modal-body">
                            <div id="u-score" class="col-lg-12">
                                <span  class="score-user-low">متاسفانه شما سکه ای دریافت نکردین</span>
                            </div>
                            <div id="upset-user">
                                <img src="{{asset("images/sad-clipart.png")}}"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-end-win" type="button" data-dismiss="modal" class="btn btn-red">مشاهده جواب های صحیح</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>وقت شما به پایان رسید</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{route('indexRoute')}}" id="btn-end-win" class="btn btn-danger center-block2">ورود به صفحه اصلی سایت</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#lowModal" id="low-time" data-toggle="modal"></a>
            <a href="#winModal" id="win-time" data-toggle="modal"></a>
            <a href="#myModal" id="end-time" data-toggle="modal"></a>
        </div>
    </div>
    <!--shipping----------------------------------->
@endsection
@section('js')
    <script>
        //document.getElementById("low-time").click();
        var t;
        $(function(){
            var i=0;
            var j=0;
            $('input[type=radio]').each(function () {
                i++;
                $(this).attr("id","answer"+i);
            });
            $("label").each(function () {
                j++;
                $(this).attr("for","answer"+j);
            });
        });


        function timer(data, lnk){
            dat=document.getElementById(data);
            var time=(dat.innerHTML).split(":"); var done=0;
            if (time[2]>0) time[2]--;
            else{
                time[2]=59;
                if(time[1]>0) time[1]--;
                else{time[1]=59;
                    if (time[0]>0) time[0]--;
                    else { clearTimeout(id[data]); done=1;} }}
            if(!done){
                dat.innerHTML=time[0]+":"+time[1]+":"+time[2];
                if(time[2]==0 && time[1]==0 && time[0]==0)
                {
                    document.getElementById("end-time").click();
                    //$("form").empty();
                    $("#end-time").empty();
                    $("#btn-end-quiz").css("background-color","#fc5858");
                    $("#btn-end-quiz").css("border","1px solid #fc5858");
                    document.getElementById("btn-end-quiz").disabled = true;
                    document.getElementById("btn-end-quiz").hidden = false;
                    document.getElementById("btn-end-loader").hidden = true;
                }
                id[data]=setTimeout("timer('"+data+"')", 1000);
                t=id[data];


            }
        }

        $(document).ready(function () {

            $('form').on('submit', function (e) {
                clearTimeout(t);
                document.getElementById("btn-end-quiz").disabled = true;
                document.getElementById("btn-end-quiz").hidden = true;
                document.getElementById("btn-end-loader").hidden = false;
                e.preventDefault();
                $('#cover-spin').show();
                var formData = new FormData($(this)[0]);
                /*      $("form").empty();
                      $("#timer-score").empty();
                      $("#end-time").empty();*/
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route("matchSubmitRoute")}}',
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (msg)
                    {
                        $('#cover-spin').hide();
                        if(msg['score']==0)
                        {
                            document.getElementById("low-time").click();
                            $("#btn-end-quiz").css("background-color","#fc5858");
                            $("#btn-end-quiz").css("border","1px solid #fc5858");
                            document.getElementById("btn-end-quiz").hidden = false;
                            document.getElementById("btn-end-loader").hidden = true;
                            $("#end-time").empty();
                            $("#timer-score").empty();
                            for(var i=0;i<=msg[0].length-1;i++)
                            {
                                $("#each"+[i]).each(function () {
                                    $(".check-false"+[i]).css("display","inline-block")
                                    $(".correct"+[i]).css("display","inline-block")
                                    $('.answer-response'+[i]).text(msg[0][i]['answer']);

                                });
                            }

                        }
                        else
                        {
                            $("#end-time").empty();
                            $("#timer-score").empty();
                            //$("#btn-end").empty();
                            $("#score-user").append(msg['score']);
                            document.getElementById("win-time").click();
                            $("#btn-end-quiz").css("background-color","#fc5858");
                            $("#btn-end-quiz").css("border","1px solid #fc5858");
                            document.getElementById("btn-end-quiz").hidden = false;
                            document.getElementById("btn-end-loader").hidden = true;
                            for(var i=0;i<=msg[0].length-1;i++)
                            {
                                if(msg[0][i][i+1]===true)
                                {
                                    $(".check-true"+[i]).css("display","inline-block")
                                }

                                else
                                {
                                    $("#each"+[i]).each(function () {
                                        $(".check-false"+[i]).css("display","inline-block")
                                        $(".correct"+[i]).css("display","inline-block")
                                        $('.answer-response'+[i]).text(msg[0][i]['answer']);

                                    });

                                }

                            }


                            /*  $('#score-user').append(msg);
                                 document.getElementById("m-score").style.display = "";
                                 document.getElementById("score-user").style.display = "";
                                 document.getElementById("score-user").textContent=msg;
                                 document.getElementById("win-user").style.display = "";
                                 document.getElementById("btn-score").style.display = "";*/




                        }
                    },
                    error: function () {


                    }
                });
            });
        });

    </script>

    <script type="text/javascript">
        var id=new Array(50);
        timer('time');
    </script>
@endsection
