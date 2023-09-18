@extends('layouts.akasa')
@section('content')
<!-- Styles -->
<link href="{{ asset('css/company.css') }}" rel="stylesheet">
    <!--Page Title Banner-->
    <div id="intro-example" class="d-flex align-items-center img-fluid" style="background-image:url('{{ asset('img/banner/aboutus.jpg') }}');height: 300px;background-position: 35% 75%;">
      <div class="container text-white text-end">
        <h1 class="display-4">About Akasa</h1>
        <h6 class="fst-italic">Akasa provide thermal solutions for PC, IPC and specialist applications worldwide.</h6>
      </div>
    </div>


    <!--Page Content-->
    <div class="aboutus container" style="border: 0px solid #73AD21;">
        <div class="mt-5 col-md-10" style="margin: 0 auto;">
            <h2 class="text-center fw-bolder" style="border: 0px solid #73AD21;">Welcome to our company!</h2>
            <p class="m-3 m-md-0" style="border: 0px solid #000;">Akasa design and manufacture a comprehensive range of high quality technology products including coolers, heatsinks and fans. We work closely with Intel and AMD to ensure our products match the complex demands of CPU and form-factor technology. So when new, advanced technology arrives, Akasa have the products and expertise to make it work for you.</p>
        </div>
        <!--step-->
        <div class="mt-5 col-md-12" style="margin: 0 auto;">
            <div class="accordion accordion-flush" id="accordionExample" style="border: 0px solid #255541;">
                <!--01-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Design</button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">A</span>kasa have extensive design and development capability in Europe, Hong Kong and Taiwan. Our thermal engineers are equipped with sophisticated computer modelling software for measuring noise and case vibrations, airflow, static pressure and temperature control. We are specifically developing advanced expertise in energy saving and silent operation technology. New products are subject to rigorous testing before committing them to market.
                            </div>
                            <div class="row_aboutus_img col-12 col-md-6 p-0" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/aboutus_design.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                  <!--02-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Quality
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6 order-md-2" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">A</span>kasa is 100% dedicated to serving customers with reliable products which provide certainty in use. We never compromise product quality. We use high grade materials sourced from dependable suppliers. All our products are manufactured under strict quality control standards managed from our Taiwan office.
                            </div>                   
                            <div class="row_aboutus_img col-12 col-md-6 p-0 order-md-1" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/aboutus_quality.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>                            
                        </div>
                    </div>
                  </div>
                </div>
                  <!--03-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Manufacturing
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">A</span>kasa own and manage manufacturing plant in China with modern facilities including computer aided precision tooling and injection moulding. For specialist technology requirements we have a network of strategic partners in China, Taiwan and Europe.
                            </div>
                            <div class="row_aboutus_img col-12 col-md-6 p-0" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/about_manufacturing.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                  <!--04-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      Markets
                    </button>
                  </h2>
                  <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6 order-md-2" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">A</span>kasa is a leading supplier of thermal solutions to the global electronics industry: PC, IPC, electronic manufacturing and contract manufacturing. Our products are employed in numerous applications from sophisticated scientific IT to robust mechanical devices.
                            </div>               
                            <div class="row_aboutus_img col-12 col-md-6 p-0 order-md-1" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/about_markets.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                  <!--05-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      Expert Knowledge at your Service
                    </button>
                  </h2>
                  <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">W</span>hen the problem is unwanted heat, Akasa have the expertise to help you deliver a winning solution. We work with customers on product configuration to determine the most effective thermal solution. Whatever the problem, thermal failure in an existing product or too much heat in a new system, we have the expertise to solve it. For free advice on how we can help improve the thermal performance of your products, contact info@akasa.com.tw
                            </div>
                            <div class="row_aboutus_img col-12 col-md-6 p-0" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/about_service.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                  <!--06-->
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                      Akasa Retail Brand
                    </button>
                  </h2>
                  <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                    <div class="accordion-body p-0">
                        <div class="row m-0" style="background-color: #DCDCDC;border: 0px solid #000;">
                            <div class="row_aboutus_text col-12 col-md-6 order-md-2" style="border: 0px solid #73AD21;"><span class="h4 fw-bolder">O</span>ur innovative end-user products are sold under the distinctive Akasa brand through etailers and retailers worldwide. We have hundreds of Akasa branded products including cables, coolers, card readers, cases, external enclosures, fans in many colours, notebook coolers and power supplies, Akasa products regularly win industry awards.
                            </div>                   
                            <div class="row_aboutus_img col-12 col-md-6 p-0 order-md-1" style="border: 0px solid #73AD21;">
                                <img src="{{ asset('img/aboutus/about_retailbrand.png') }}" alt="" class="img-fluid" style="border: 0px solid #AA5821;">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="milestone">
            <h5 class="text-center">MILESTONE</h5>
            <h3 class="text-center fw-bolder">Moments and breakthroughs which made Akasa</h3>

            <section class="milestone_timeline" style="border: 0px solid #73AD21;">
                <!--01-->
                <div class="timeline-block timeline-block-left" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">1997</span>
                        <p><b>•</b> Founded in Taipei & London (EMEA)</p>
                    </div>
                </div>
                <!--02-->
                <div class="timeline-block timeline-block-right" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">1998-2000</span>
                        <p><b>•</b> Akasa (Asia) Corp. established (APAC & NA)<br><b>•</b> Official launch of brand “Akasa”</p>
                    </div>
                </div>
                <!--03-->
                <div class="timeline-block timeline-block-left" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">2001-2003</span>
                        <p><b>•</b> Brazil office established (South America)<br><b>•</b> Akasa brand positioned as a market leader in the PC manufacturing sector</p>
                    </div>
                </div>
                <!--04-->
                <div class="timeline-block timeline-block-right" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">2005-2007</span>
                        <p><b>•</b> Fan manufacturing facilities opened in Dong Guang, China<br><b>•</b> New facility, Dachi Metal and Electronics Ltd., operated in Dong Guang China for assembly</p>
                    </div>
                </div>
                <!--05-->
                <div class="timeline-block timeline-block-left" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">2012-2016</span>
                        <p><b>•</b> First range of Fanless Chassis for Intel®-based Thin- Mini ITX launches<br><b>•</b> First range of Raspberry Pi Chassis & Cooling 
  solutions for AMD AM4 socket</p>
                    </div>
                </div>
                <!--06-->
                <div class="timeline-block timeline-block-right" style="border: 0px solid red;">
                    <div class="row_milestone_dot"></div>
                    <div class="row_milestone_content">
                        <span class="row_milestone_time">2022</span>
                        <p><b>•</b> Holland office established (for European Union customers)</p>
                    </div>
                </div>      
            </section>
            <!-- <div class="row_milestone_dot" style="margin: 0 auto;margin-top: -50px;"></div> -->
            <!-- <p style="border: 0px solid red;text-align: center;margin-top: -50px;font-weight: bold;color: #C8102E;font-size: 1.2rem;">NOW</p> -->
            <!--logo-->
                <div style="clear: both;margin: 0 auto;background-color: #fff;border: 0px solid red;margin-top: -25px;">
                    <img src="{{ asset('img/aboutus/about_mailestone_logo.png') }}" class="img-fluid" alt="akasa-logo" style="margin: 0 auto;">
                </div>
        </div>
    </div>
@endsection