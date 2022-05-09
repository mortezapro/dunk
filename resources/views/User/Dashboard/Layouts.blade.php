<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset("userDashboard/css/rtl/bootstrap.rtl.css")}}" rel="stylesheet">
    <link href="{{asset("userDashboard/css/plugins/metisMenu/metisMenu.min.css")}}" rel="stylesheet">
    <link href="{{asset("userDashboard/css/plugins/timeline.css")}}" rel="stylesheet">
    <link href="{{asset("userDashboard/css/rtl/sb-admin-2.css")}}" rel="stylesheet">
    <link href="{{asset("userDashboard/css/plugins/morris.css")}}" rel="stylesheet">
    <link href="{{asset("userDashboard/css/font-awesome/font-awesome.min.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("userDashboard/css/rtl/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("css/style.css")}}" rel="stylesheet">
    @yield("head")
</head>
<body>
<div id="wrapper">

    <!-- Navigation -->
    @include("User.Dashboard.Partials.nav-right")
    <div id="page-wrapper">
        @yield("content")
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery Version 1.11.0 -->
<script src="{{asset("userDashboard/js/jquery-1.11.0.js")}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset("userDashboard/js/bootstrap.min.js")}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset("userDashboard/js/metisMenu/metisMenu.min.js")}}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{asset("userDashboard/js/raphael/raphael.min.js")}}"></script>
<script src="{{asset("userDashboard/js/morris/morris.min.js")}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset("userDashboard/js/sb-admin-2.js")}}"></script>
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

</script>
<script>
$(document).on('click',function(){
$('.collapse').collapse('hide');
})
</script>
</body>

</html>
