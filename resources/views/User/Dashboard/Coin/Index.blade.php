@extends("User.Dashboard.Layouts")
@section("head")
    <title>سکه های من</title>
    <meta name="description" content="">
@endsection
@section("content")

<div class="row">
  
<div class="coin">
    <img src="{{asset("images/nav-user/myCoin.png")}}"/>
    <span class="myCoin">سکه های من :</span>
    <span class="countCoin">{{$user_coin}}</span>
    </div>
</div>

<style>
.coin
{
    margin-top: 258px;
    margin-right: auto;
    margin-left: auto;
    width: 50%;
}
.coin img
{
    width:125px;
}
.myCoin
{
    font-size:45px;
}
.countCoin
{
    font-size:45px;
    color:#ef1212;
}
    .mrgt-right
    {
        float:right;
        margin-right:20%;
    }
    
.avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

  @media (max-width: 768px) {
       .coin
    {
         margin-right: 0;
    margin-left: 0;
    width:100%;
        margin-top:50px;
  
    }
    .coin img
    {
        width:70px;
    }
    .myCoin
    {
        font-size:20px;
    }
        .countCoin
    {
        font-size:20px;
        color:#ef1212;
    }
}
 
</style>


@endsection
