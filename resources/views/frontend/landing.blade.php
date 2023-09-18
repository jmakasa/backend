@extends('layouts.akasa')

@section('content')
@include('frontend.banner')
    <!--galleryCSS===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
    <div class="row justify-content-center">
        <div class="newprductbar container mt-md-5" style="background-color: #fff;/*margin:3rem auto 3rem auto;">
            <div class="row" style="border:0px solid #000;">
                <h3 class="text-center p-4">NEW PRODUCTS</h3>
                <div class="HomeNewproduct slick-slider slick-dotted">
                    <div class="row_HomeNewproduct_list card h-100">
                        <a href="#"><img src="./img/home/newproduct/AK-LC4003HP01_g01.jpg" class="img-fluid" alt="" style=""></a>
                        <div class="card-body">
                            <a href="#">Product Name01</a>
                            <div class="">Omni-Directional Tri-Band Wi-Fi Antenna</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card h-100">
                        <a href="#"><img src="./img/home/newproduct/AK-FN108_g02.jpg" class="img-fluidnewimg" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Product Name01</a>
                            <div class="pro-title.">Product Title01</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card h-100">
                        <a href="#"><img src="./img/home/newproduct/AK-FN073_g01.jpg" class="img-fluid" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Alucia SC</a>
                            <div class="pro-title.">Dual Radiator Liquid CPU cooler kit</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card">
                        <a href="#"><img src="./img/home/newproduct/AK-FN117_118_g04.jpg" class="img-fluid" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Alucia SC</a>
                            <div class="pro-title.">Dual Radiator Liquid CPU cooler kit</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card">
                        <a href="#"><img src="./img/home/newproduct/AK-CC4011EP01_g04.jpg" class="img-fluid" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Product Name01</a>
                            <div class="pro-title.">Product Title01</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card">
                        <a href="#"><img src="./img/home/newproduct/AK-FN108_g02.jpg" class="img-fluid" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Product Name01</a>
                            <div class="pro-title.">Product Title01</div>
                        </div>
                    </div>
                    <div class="row_HomeNewproduct_list card">
                        <a href="#"><img src="./img/home/newproduct/AK-FN112-WH_f00.jpg" class="img-fluid" alt="" style="width: 120px;border:1px solid #fff;margin:auto;"></a>
                        <div class="card-body">
                            <a href="#" class="pro-name.">Product Name01</a>
                            <div class="pro-title.">Product Title01</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--HomeBody:Series PRODUCTS-D-->
        <div class="seriesbar container-fluid mt-md-5" style="background-color: #fff;border:0px solid #000;">
            <h3 class="p-4 text-center">EXPLORE OUR WIDE RANGE OF PRODUCTS</h3>
            <div class="row h-100" style="border:0px solid #000;">
                <div class="col-12 col-md-3 ps-md-0 pe-md-0 seriesbar_intro" style="border:0px solid #000;/*width: 26.4%;">
                    <div class="row_seriesbar_intro_text">
                        <h1 class="text-dark">Turing</h1>
                        <h5 class="text-dark">Fanless Cases</h5>
                        <i class="bi bi-arrow-right-circle"></i>
                    </div>
                    <a href="#" class="h-100">
                        <div class="row h-100" style="border:0px solid red;">
                            <img src="./img/home/seriesproduct/series_turing.jpg" srcset="./img/home/seriesproduct/series_turing.jpg 1x, ./img/home/seriesproduct/series_turing_h390.jpg 2x">
                            <!-- <img class="" alt="" src="//cdn.shopify.com/s/files/1/1520/4366/files/Main_banner_compressed_552x584@2x.jpg?v=1648682604" width="552" height="584"> -->
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-9" style="border:0px solid #000;/*width: 73.6%;">
                    <div class="row" style="border:0px solid red;">
                        <div class="col-12 col-md-7 pe-md-0 seriesbar_intro" style="border:0px solid red;">
                            <div class="row_seriesbar_intro_text">
                                <h1 class="text-white">SOHO</h1>
                                <h5 class="text-white">Addressable RGB</h5>
                                <i class="bi bi-arrow-right-circle"></i>
                            </div>
                            <a href="#" class="h-100">
                                <div class="row h-100">
                                    <img src="./img/home/seriesproduct/series_soho.jpg" srcset="./img/home/seriesproduct/series_soho.jpg 1x, ./img/home/seriesproduct/series_soho_2x.jpg 2x" class="img-fluid">
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-5 pe-md-0 seriesbar_intro" style="border:0px solid red;">
                            <div class="row_seriesbar_intro_text pb-md-4">
                                <h1 class="text-white">OTTO</h1>
                                <h5 class="text-white">Premium Cooling Fan</h5>
                                <i class="bi bi-arrow-right-circle"></i>
                            </div>
                            <a href="#" class="h-100">
                                <div class="row h-100">
                                    <img src="./img/home/seriesproduct/series_otto.jpg" class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row seriesbar_intro_p">
                        <div class="col-12 col-md-5 pe-md-0 seriesbar_intro" style="border:0px solid red;">
                            <div class="row_seriesbar_intro_text pb-md-4">
                                <h1 class="text-dark">Gecko</h1>
                                <h5 class="text-dark">System Cooling</h5>
                                <i class="bi bi-arrow-right-circle"></i>
                            </div>
                            <a href="#" class="h-100">
                                <div class="row h-100" style="border:0px solid red;">
                                    <img src="./img/home/seriesproduct/series_gecko.jpg" srcset="./img/home/seriesproduct/series_gecko.jpg 1x, ./img/home/seriesproduct/series_gecko_2x.jpg 2x" class="img-fluid">
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-7 pe-md-0 seriesbar_intro" style="border:0px solid red;">
                            <div class="row_seriesbar_intro_text">
                                <h1 class="text-white">Vegas</h1>
                                <h5 class="text-white">RGB & aRGB</h5>
                                <i class="bi bi-arrow-right-circle"></i>
                            </div>
                            <a href="#" class="h-100">
                                <div class="row h-100" style="border:0px solid red;">
                                    <img src="./img/home/seriesproduct/series_vegas.jpg" srcset="./img/home/seriesproduct/series_vegas.jpg 1x, ./img/home/seriesproduct/series_vegas_2x.jpg 2x" class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--HomeBody:POPULAR TOPIC-C-->
        <div class="topicbar container" style="background-color: #fff;margin:5rem auto 5rem auto;">
            <div class="d-flex topicbar_content">
                <div class="col-md-4 row_topicbar_content_tab">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <h3 class="p-md-3">POPULAR TOPIC</h3>

                        <button class="nav-link active" id="v-pills-topic01-tab" data-bs-toggle="pill" data-bs-target="#v-pills-topic001" type="button" role="tab" aria-controls="v-pills-topic01" aria-selected="true">Intel LGA1700</button>

                        <button class="nav-link" id="v-pills-topic02-tab" data-bs-toggle="pill" data-bs-target="#v-pills-topic002" type="button" role="tab" aria-controls="v-pills-topic02" aria-selected="false">HTPC</button>

                        <button class="nav-link" id="v-pills-topic03-tab" data-bs-toggle="pill" data-bs-target="#v-pills-topic003" type="button" role="tab" aria-controls="v-pills-topic03" aria-selected="false">Waterproof Cases</button>

                        <button class="nav-link" id="v-pills-topic04-tab" data-bs-toggle="pill" data-bs-target="#v-pills-topic004" type="button" role="tab" aria-controls="v-pills-topic04" aria-selected="false">2.5Gb Ethernet</button>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <h3 class="text-center pb-4 d-md-none">POPULAR TOPIC</h3>

                        <div class="tab-pane fade show active" id="v-pills-topic001" role="tabpanel" aria-labelledby="v-pills-topic001-tab">
                            <div class="card-header" role="tab" id="v-collapse-heading-topic001">
                                <a data-bs-toggle="collapse" href="#v-collapse-topic001" data-bs-parent="#v-pills-tabContent" aria-expanded="true" aria-controls="v-collapse-topic001">Intel LGA1700</a>
                            </div>

                            <div id="v-collapse-topic001" class="collapse show" role="tabpanel" aria-labelledby="v-collapse-heading-topic001" data-bs-parent="#v-pills-tabContent">
                                <div class="hover-mask">
                                    <a href="#">
                                        <img src="./img/home/topic/topic_intelLGA1700.jpg" class="img-fluid">
                                        <span class="row_topic_text">Intel LGA1700 <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-topic002" role="tabpanel" aria-labelledby="v-pills-topic002-tab">

                            <div class="card-header" role="tab" id="v-collapse-heading-topic002">
                                <a data-bs-toggle="collapse" href="#v-collapse-topic002" data-bs-parent="#v-pills-tabContent" aria-expanded="false" aria-controls="v-collapse-topic002">HTPC</a>
                            </div>

                            <div id="v-collapse-topic002" class="collapse" role="tabpanel" aria-labelledby="v-collapse-heading-topic002" data-bs-parent="#v-pills-tabContent">
                                <div class="hover-mask">
                                    <a href="#">
                                        <img src="./img/home/topic/topic_htpc_02.jpg" class="img-fluid">
                                        <span class="row_topic_text">HTPC<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="v-pills-topic003" role="tabpanel" aria-labelledby="v-pills-topic003-tab">
                            <div class="card-header" role="tab" id="v-collapse-heading-topic003">
                                <a data-bs-toggle="collapse" href="#v-collapse-topic003" data-bs-parent="#v-pills-tabContent" aria-expanded="false" aria-controls="v-collapse-topic002">Waterproof Cases</a>
                            </div>
                            <div id="v-collapse-topic003" class="collapse" role="tabpanel" aria-labelledby="v-collapse-heading-topic003" data-bs-parent="#v-pills-tabContent">
                                <div class="hover-mask">
                                    <a href="#">
                                        <span class="row_topic_text">Waterproof Cases<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                            </svg></span>
                                        <img src="./img/home/topic/topic_waterproof.jpg" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-topic004" role="tabpanel" aria-labelledby="v-pills-topic004-tab">
                            <div class="card-header" role="tab" id="v-collapse-heading-topic004">
                                <a data-bs-toggle="collapse" href="#v-collapse-topic004" data-bs-parent="#v-pills-tabContent" aria-expanded="false" aria-controls="v-collapse-topic002">2.5Gb Ethernet</a>
                            </div>
                            <div id="v-collapse-topic004" class="collapse" role="tabpanel" aria-labelledby="v-collapse-heading-topic004" data-bs-parent="#v-pills-tabContent">
                                <div class="hover-mask">
                                    <a href="#">
                                        <img src="./img/home/topic/topic_ethernet_02.jpg" class="w-100">
                                        <span class="row_topic_text">2.5Gb Ethernet<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--HomeBody:FEATURED BLOG-B-->
        <div class="Homeblogbar container" style="background-color: #fff;margin:5rem auto 5rem auto;">
            <div class="row" style="border:0px solid #000;">
                <h3 class="p-4 text-center">FEATURED BLOG</h3>
                <div class="HomeFeatureBlog slick-slider slick-dotted">
                    <div class="row_Homeblogbar_list">
                        <a href="https://akasa-tech.medium.com/fanless-pcs-the-ultimate-home-theatre-pc-setup-f6a72430173b" target="_blank"><img src="./img/home/blog/Home_blogbar_20210618.jpg" alt="" class="w-100"></a>
                        <div class="blogbar_intro p-2">
                            <span class="text-muted">18 JUN 2021</span>
                            <p class="h5">Fanless PCs: The Ultimate Home Theatre PC Setup</p>
                            <a href="https://akasa-tech.medium.com/fanless-pcs-the-ultimate-home-theatre-pc-setup-f6a72430173b" target="_blank">
                                <span class="fw-bolder h6">READ MORE<i class="bi bi-arrow-right-circle"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="row_Homeblogbar_list">
                        <a href="https://akasa-tech.medium.com/akasa-collaborates-with-swiss-school-on-pc-building-project-62ee896aa57e" target="_blank">
                            <div class="overlaymask"><img src="./img/home/blog/Home_blogbar_20210511.jpg" alt="" class="w-100"></div>
                        </a>
                        <div class="blogbar_intro p-2">
                            <span class="text-muted">11 May 2021</span>
                            <p class="h5">Akasa collaborates with Swiss school on PC building project</p>
                            <a href="https://akasa-tech.medium.com/akasa-collaborates-with-swiss-school-on-pc-building-project-62ee896aa57e" target="_blank"><span class="fw-bolder h6">READ MORE<i class="bi bi-arrow-right-circle"></i></span></a>
                        </div>

                    </div>
                    <div class="row_Homeblogbar_list">
                        <a href="https://akasa-tech.medium.com/cut-copy-and-thermal-paste-9ed39dae92a" target="_blank"><img src="./img/home/blog/Home_blogbar_20200828.jpg" alt="" class="w-100"></a>
                        <div class="blogbar_intro p-2">
                            <span class="text-muted">28 AUG 2020</span>
                            <p class="h5">Cut, Copy and Thermal Paste</p>
                            <a href="https://akasa-tech.medium.com/cut-copy-and-thermal-paste-9ed39dae92a" target="_blank">
                                <span class="fw-bolder h6">READ MORE<i class="bi bi-arrow-right-circle"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="row_Homeblogbar_list">
                        <a href="https://akasa-tech.medium.com/give-a-roar-of-excitement-for-the-new-tiger-canyon-the-11th-generation-of-intels-nuc-line-hits-dfaab0709095" target="_blank"><img src="./img/home/blog/Home_blogbar_20210624.jpg" alt="" class="w-100"></a>
                        <div class="blogbar_intro p-2">
                            <span class="text-muted">06 Jun 2021</span>
                            <p class="h5">Give a roar of excitement for the new Tiger Canyon: the 11th generation of Intel’s NUC line hits shelves!</p>
                            <a href="https://akasa-tech.medium.com/give-a-roar-of-excitement-for-the-new-tiger-canyon-the-11th-generation-of-intels-nuc-line-hits-dfaab0709095" target="_blank">
                                <span class="fw-bolder h6">READ MORE<i class="bi bi-arrow-right-circle"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--HomeBody:CAMPAIGNS & EVENTS-->
        <div class="eventbar" style="background-color: #eeeeee;padding-top: 50px; padding-bottom: 50px;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-5 pe-md-0">
                        <img src="./img/home/event/embeddedworld_2022_06.jpg" class="w-100">
                    </div>
                    <div class="col-12 col-md-6 ps-md-0">
                        <div class="row_event_intro p-5 h-100" style="background-color: #fff;">
                            <small class="text-muted">CAMPAIGNS & EVENTS</small>
                            <p class="fw-bolder h1" style="">Embedded World</p>
                            <small class="fw-bolder text-muted h5">21-23 JUN 2022</small>
                            <p class="h5 mt-4 mb-4">Enter into the Akasa world! <br>Meet us at booth: Hall 1, 658</p>
                            <a href="#" target="_blank" class="seemore">LEARN MORE<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--HomeBody:MEDIA COVERAGE-->
        <div class="mediabar container mt-md-5">
            <h3 class="p-4 text-center">MEDIA COVERAGE</h3>
            <div class="row">
                <div class="col-12 col-md-6 mb-3" style="border:0px solid #000;/*background-image: url('./img/home/media/media_video.jpg');background-repeat: no-repeat;">
                    <div class="row_media_intro col-11 col-md-2" style="border:0px solid red;">
                        <small class="text-muted"># VIDEO</small>
                        <p class="fw-bolder h4" style="">Robtech</p>
                        <h6 class="mb-4">“ This video goes over three different Akasa fanless cases for the Raspberry Pi 4. Basic installation & temperatures at stock and overclocked CPU speeds are tested...”</h6>
                        <a href="#" target="_blank" class="seemore">LEARN MORE<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg>
                        </a>
                    </div>
                    <img src="./img/home/media/media_video_02.jpg" class="w-100" style="border:0px solid #eee;">
                </div>
                <div class="col-12 col-md-6 mb-3" style="border:0px solid #000;">
                    <div class="row_media_intro col-11 col-md-2" style="border:0px solid red; ">
                        <small class="text-muted"># BLOG</small>
                        <p class="fw-bolder h4" style="">DIYODE</p>
                        <h6 class="mb-4">''...in even the most hostile of situations, the GemPro case can keep your Raspberry Pi processor, power management and USB controller cool, even under heavy overclocking...''</h6>
                        <a href="#" target="_blank" class="seemore">LEARN MORE<svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor" class="bi bi-arrow-right-circle ps-md-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg></a>
                    </div>
                    <img src="./img/home/media/media_blog_02.jpg" class="w-100" style="border:0px solid #eee;">
                </div>
            </div>
        </div>

        
    </div>

<!--HomeBody:NEWS LETTER-C-->
<input type="checkbox" name="" id="sideMenu-active">
        <div class="sideMenu" style="border:0px solid #000;">
            <div class="row">
                <div class="col-10 col-md-5" style="border:0px solid #666;">
                    <img src="./img/dropdownmenu/newsletter1.png" class="img-fluid m-2">
                </div>
                <div class="col-12 col-md-7" style="border:0px solid #666;">
                    <label for="sideMenu-active"><i class="fa fa-times" aria-hidden="true"></i></label>

                    <h2 class="fw-bolder pt-md-4">Welcome to <br>the Akasa Family</h2>
                    <h6 class="text-muted">Be the first to know! Subscribe now for <br>free alerts on newly added products.</h6>
                    <div class="subscribe-wrapper pt-md-3">
                        <div class="subscribe-form" style="border:0px solid #666;">
                            <form action="#">
                                <input placeholder="email@example.com" type="text">
                                <button class="btn btn-outline-danger">subscribe </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <label for="sideMenu-active">
                <div style="border: 0px solid #000;">NEWSLETTER</div>
            </label>
        </div>
@endsection