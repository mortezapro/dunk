@if($errors->any())
    <div class="alert alert-danger" style="background-color: red;color: #fff;">
        @foreach($errors->all() as $error)
            <p style="color: white;text-align: right">{{$error}}</p>
        @endforeach
    </div>
@endif


