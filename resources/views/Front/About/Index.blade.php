@extends('Front.Layouts')
@section('main')
    <section>
        <!--about-------------------------------------->
        <div class="container-main">
            <div class="col-12">
                <section class="about">
                    <div class="about-us-head">
                        <div class="about-us-head-inner">
                            <img src="{{asset("dashboard/dist/img/headerpic.png")}}" class="mb-4">
                            <h1>مقررات و روش کار سایت جایزه دون</h1>
                            <div class="about-us-head-content mt-4 text-right">
                                <p style="white-space: pre-line;">
                                    {{$setting->about_text}}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--about-------------------------------------->
    </section>
@endsection
