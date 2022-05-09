@if($errors->any())
    <div class="massege-light" style="width: 100%; margin: 0 0 35px 0;padding: 20px 10px">
        @foreach($errors->all() as $error)
            <p style="color: #a37731;text-align: right;font-size: 14px">{{$error}}</p>
        @endforeach
    </div>
@endif


