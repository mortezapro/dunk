

            <html><head><style>
 body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding-left: 8mm;
        padding-top: 5mm;
    }
	.subpage{
	display: inline-block;
   /* border: 1pt solid;*/
    height: 17mm;
    width: 36.4mm;
	padding: 7mm 0;
	}
	p{
	    text-align:center
	}
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
			
        }
    }

</style>



</head>
<body>


<div class="book" style="">
@php
				    $num=0;
                  $all=array();
				@endphp
                @foreach($codes as $code)

				 @php
					
                   array_push($all,$code->code_text.$code->code_number);
                   $num++;
				@endphp
                @endforeach
                
                @php
                $v=0;
                for($m=0;$m< ceil(count($all)/9);$m++)
                {
                $p=1;
                $rr=1;
                echo'<div class="page" style="padding-right: 21.1mm;">';
                for($rr;$rr<=4;$rr++){
                if($rr==1){
                //satre aval
                
                echo '<div id="row" style="margin-left: 7.5mm;margin-top: 10mm;">';
                if($p==1){
               
                
                echo'<div class="subpage"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
                $p++ ;
                $v++;

                }
                if($p==2){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style="text-align: center; ">'.@$all[$v].'</p></div>';
                $p++;
                $v++;
                }
                if($p==3){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
                $p++;
                $v++;
                }
                echo'</div>';
               // $r++;
                $p=1;
                }
                if($rr==2){
                //satre dovom
                echo '<div id="row" style="margin-left: 7.5mm;margin-top: 73mm;">';
                if($p==1){
               
                
                echo'<div class="subpage"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
                $p++ ;
                $v++;

                }
                if($p==2){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style="text-align: center; ">'.@$all[$v].'</p></div>';
                $p++;
                $v++;
                }
                if($p==3){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
               // $p++;
               $v++;
                }
                echo'</div>';
                $p=1;

                }
                if($rr==3){
                //satre sevom
                echo '<div id="row" style="margin-left: 7.5mm;margin-top: 73mm;">';
                if($p==1){
               
                
                echo'<div class="subpage"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
                $p++ ;
                $v++;
                }
                if($p==2){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style="text-align: center; ">'.@$all[$v].'</p></div>';
                $p++;
                $v++;
                }
                if($p==3){
                echo'<div class="subpage" style="margin-left: 28.6mm;"><p style=" text-align: center; ">'.@$all[$v].'</p></div>';
                }
                echo'</div>';
                $p=1;
                $v++;
                }
                
                }
                 echo'</div>';
    

                }
               
                @endphp
 </div>
  </div>





</body></html>