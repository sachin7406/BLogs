{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Home')
@section('meta_description', 'Welcome to DDSPLM: Your partner for digital design, engineering, and manufacturing solutions including Siemens software, PLM, and cloud CAD SaaS.')
@section('meta_keywords', 'DDSPLM, Siemens, PLM, CAD, CAE, NX CAD X, Cloud CAD, Engineering Solutions, Mechanical Design, Teamcenter, SaaS')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'DDSPLM | Digital Design & Engineering Solutions')
@section('og_description', 'Discover DDSPLM for Siemens-powered digital design, engineering, and cloud-based SaaS CAD solutions driving innovation and collaboration.')
@section('og_image', asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'DDSPLM | Empowering Next-Gen Engineering')
@section('twitter_description', 'DDSPLM delivers Siemens digital solutions for engineering, PLM, and scalable cloud-based CAD—connect with us to innovate faster!')
@section('twitter_image', asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png'))



<section class="">
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Contact details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="validateForm" method="post" action="mail.php" role="form">
                        <div class="messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Name" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="select-control" name="select" id="form_select" required>
                                            <option>Select The Solutions</option>
                                            <option>simcenter 3d</option>
                                            <option>simcenter heeds</option>
                                            <option>simcenter motersolve</option>
                                            <option>simcenter speed</option>
                                            <option>simcenter battery</option>
                                            <option>simcenter magnet</option>
                                            <option>simcenter femap</option>
                                            <option>simcenter amesim</option>
                                            <option>simcenter tire</option>
                                            <option>captial</option>
                                            <option>simcenter starccm+</option>
                                            <option>simcenter floefd</option>
                                            <option>simcenter flotherm</option>
                                            <option>simcenter flomaster</option>
                                            <option>simcenter scadas</option>
                                            <option>simcenter t3star</option>
                                            <option>simcenter teraled</option>
                                            <option>rams</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="select-control" name="type" id="form_select" required>
                                            <option>Licensing Options</option>
                                            <option>SVB Token License 100 Pack</option>
                                            <option>SVB Token License 50 Pack</option>
                                            <option>Flexible Cloud Licenses</option>
                                            <option>Perpetual</option>
                                            <option>Subscription or rental basis</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="form_phone" name="phone" class="form-control" value="" placeholder="Phone">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="form_message" name="massage" class="form-control" placeholder="Message" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn thm-btn" value="Send message">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!----------modal---------end-------------------->
    <!----------carousel-------start------------------>
    <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="picture-1">
                    <div class="container">
                        <div class="row">
                            <!---->
                            <div class="carousel-text">
                                <div class="carousel-content">
                                    <h5 class="">risk-free environment</h5>
                                    <p class="">
                                        Simulation modeling provides a safe way to test and explore different “what-if” scenarios. Make the right decision before making real-world changes.
                                    </p>
                                    <a href="/contact" class="spa-link btn btn-primary">know more</a>
                                </div>
                            </div>

                            <div class="carousel-text">
                                <div class="content-img">
                                    <img src="{{ asset('assets/images/img/logo/siemens-logo.png') }}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="picture-2">
                    <div class="container">
                        <div class="row">
                            <!------->
                            <div class="carousel-text">
                                <div class="carousel-content">
                                    <h5 class="">visualization</h5>
                                    <p>
                                        Simulation models can be animated in 2D/3D, allowing concepts and ideas to be more easily verified, communicated, and understood.
                                    </p>
                                    <a href="/contact" class="spa-link btn btn-primary">know more</a>
                                </div>
                            </div>
                            <div class="carousel-text">
                                <div class="content-img">
                                    <img src="{{ asset('assets/images/img/logo/siemens-logo.png') }}"  class="img-fluid">
                                </div>
                            </div>
                            <!------->
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="picture-3">
                    <div class="container">
                        <div class="row">
                            <!------->
                            <div class="carousel-text">
                                <div class="carousel-content">
                                    <h5 class="">handle uncertainty</h5>
                                    <p>
                                        Uncertainty in operations’ time and outcome can be easily represented in simulation models, which allows you to measure risk and find more robust solutions.
                                    </p>
                                    <a href="/contact" class="spa-link btn btn-primary">know more</a>
                                </div>
                            </div>
                            <div class="carousel-text">
                                <div class="content-img">
                                    <img src="{{ asset('assets/images/img/logo/siemens-logo.png') }}"  class="img-fluid">
                                </div>
                            </div>
                            <!------->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
    <!---------------carousel---------------end-------->
    <!---about--start--->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about-content">
                        <h1>DDSPLM Pvt. Ltd.</h1>
                        <div class="em_bar">
                            <div class="em_bar_bg"></div>
                        </div>
                        <p>
                            DDSPLM Private Limited an <b>ISO 9001:2015 Certified Company</b> achieved <b>Smart Expert Partner recognition from Siemens DISW</b> with validated expertise in <b>NX CAD</b>. As a <b>Siemens Smart Expert Partner</b>, DDSPLM has demonstrated advanced competencies by delivering best practices and proven solutions that drive customer business value.
                        </p>
                        <p>
                            We provide Industry proven solutions for design, engineering, simulation, manufacturing, and quality for an overall improvement of your designing workflow and experience. Our aim is to help our companies become Industry 4.0 ready.
                        </p>
                        <a href="https://www.ddsplm.com/about-us/" target="_blank" class="btn btn-primary">learn more</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-content">
                        <img src="{{ asset('assets/images/about/about-dis.jpg') }}" class="img-fluid " alt="about-dis">
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-----about end----->
    <!-------------------------------------->
    <section class="industry-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="industry-content">
                        industries:
                    </h1>
                    <div class="em_bar">
                        <div class="em_bar_bg"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Aerospace-Defense">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/aero.png')}}" alt="aerospace" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Aerospace & Defense</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Automotive-EV">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/shipment.png')}}" alt="automotive trans" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Automotive </h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Consumer-Products">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/consumer.png')}}" alt="comsumer" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Consumer Products</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Electronics">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/electronics.png')}}" alt="semiconductor" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Electronics </h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Industrial-Machinery">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/mechine.png')}}" alt="industrial" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Industrial Machinery</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Medical-Devices">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/device.png')}}" alt="medical" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Medical Devices</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a class="spa-link" href="Industries/Marine">
                        <div class="container-sec">
                            <img src="{{ asset('assets/images/industries logo/marine.png')}}" alt="marine icons" class="image-sec img-fluid">
                            <div class="overlay-sec">
                                <div class="text">
                                    <h6>Marine</h6>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-------------------------------------->

    <!-----service--start---->
    <section class="service-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="industry-content-1">CAE Solutions</h1>
                    <div class="em_bar">
                        <div class="em_bar_bg"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-3d" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/Simcenter-3D-Wheel-2019.1-1024x1024.png')}}" alt="1d" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter 3D</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-heeds" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/HEEDS_processs_automation_tcm27-25264.png')}}" alt="thermal_card01" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Heeds</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-motorsolve" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/MotorSolve_Webbo_Image-78192920.jpg')}}" alt="EMField" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Motorsolve</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-speed" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/Simcenter-Speed-features-250-190.png')}}" alt="ANSYS-Multiphysics_Kopplung_Flow-Meter" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Speed</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-battery" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/Simcenter-BDS-427-530.png')}}" alt="Turbomachinery-simulation" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Battery</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-magnet" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/Simcenter-Magnet-427-520.png')}}" alt="WC-connecting-wires" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Magnet</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 ">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-femap" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/ECbhyddW4AAHNUv.jpg')}}" alt="optimization" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Femap</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-card">
                        <a class="spa-link" href="/solutions/Simulation/simcenter-amesim" class="card-anchor">
                            <div class="img-hover-zoom">
                                <img src="{{ asset('assets/images/DDS-image/Amesim-wide-flow---250-190.png')}}" alt="unnamed" class="img-fluid">
                            </div>
                            <div class="img-body">
                                <h5>Simcenter Amesim</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-----service-----end----->
    <!---------------video------------------------>
    <section class="video-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="industry-content-1">Simcenter 3D video:</h1>
                    <div class="em_bar">
                        <div class="em_bar_bg"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="portofolio-card">
                        <div class="video-wrapper">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dk9mYy53cKY" allowfullscreen></iframe>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portofolio-card">
                        <div class="video-wrapper">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/7dlMIDlEFFg" allowfullscreen></iframe>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---------------video------------------------>
    <!-----blog------------>
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="blog-content">blogs</h1>
                    <div class="em_bar">
                        <div class="em_bar_bg"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" style="height:100%">
                            <div class="carousel-item active">
                                <div class="container">
                                    <div class="row mb-3">
                                        <div class="blog-col">
                                            <div class="blog-caption">
                                                <p>28 June, 2021</p>
                                                <h5>SIMCENTER™ FLOEFD™ 2021.1: WHAT’S NEW?</h5>
                                                <p>
                                                    Simcenter™ FLOEFD™ 2021.1: What’s New? The latest release of CAD-embedded Simcenter FLOEFD 2021.1 has just been announced. Simcenter FLOEFD is a CAD-embedded computational fluid dynamics (CFD) solution and supports NX, Solid Edge, CATIA V5 ...
                                                </p>
                                                <a href="https://www.ddsplm.com/blog/simcenter-floefd-2021-1-whats-new/" target="blank" class="btn btn-learn">read more</a>
                                            </div>
                                        </div>
                                        <div class="blog-col">
                                            <img src="{{ asset('assets/images/blog/Blog-Title.jpg')}}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="container">
                                    <div class="row mb-3">
                                        <div class="blog-col">
                                            <div class="blog-caption">
                                                <p>05 June, 2021</p>
                                                <h5>GO DIGITAL SAVE THE ENVIRONMENT</h5>
                                                <p>
                                                    Go Digital Save the Environment Digitalizing New Product Development. Benefits and challenges. Benefits Improved Collaboration and Teamwork Data security and revision control Integrated Project Management Process and standards ...
                                                </p>
                                                <a href="https://www.ddsplm.com/blog/go-digital-save-the-environment/" target="blank" class="btn btn-learn">read more</a>
                                            </div>
                                        </div>
                                        <div class="blog-col">
                                            <img src="{{ asset('assets\images\blog\Go-Paperless-_June.png')}}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="container">
                                    <div class="row mb-3">
                                        <div class="blog-col">
                                            <div class="blog-caption">
                                                <p>28 June, 2021</p>
                                                <h5>THERMAL FATIGUE: SOME HOT FEATURES IN SIMCENTER 3D DURABILITY</h5>
                                                <p>
                                                    Thermal fatigue: some hot features in Simcenter 3D Durability Fatigue failure, especially in safety-relevant parts, could ruin your brand name. Or it could even have hazardous financial and legal repercussions for your company if it could be held ...
                                                </p>
                                                <a target="blank" href="https://www.ddsplm.com/blog/thermal-fatigue-some-hot-features-in-simcenter-3d-durability/" class="btn btn-learn">read more</a>
                                            </div>
                                        </div>
                                        <div class="blog-col">
                                            <img src="{{ asset('assets\images\blog\Blog-Title.jpg')}}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------blog------------end-------->
    <!---news---start------->
    <section class="news-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="case-content"><span>case study</span></h1>
                </div>
            </div>
            <div id="demo" class="carousel slide " data-ride="carousel">
                <!-- The slideshow -->
                <div class="row">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/p3.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="FLOEFD-PDF/Siemens PLM Simcenter FLOEFD Danfoss Drives - Success Slide.pdf" target="blank">
                                                        Danfoss Drives
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/ThyssenKrupp.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="FLOMSTER-PDF/Siemens PLM Simcenter Flomaster ThyssenKrupp - Success Slide.pdf" target="blank">
                                                        ThyssenKrupp
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/Facebook-data-saver.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="FLOTHERM-PDF/Siemens SW Simcenter Flotherm Facebook Success Slide.pdf" target="blank">
                                                        Facebook’s datacenter server design
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/Hilti.webp')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="SIMCENTER-3D-PDF/Siemens SW Hilti Case Study.pdf" target="blank">
                                                        Hilti
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/Allseas.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="FEMAP-PDF/Femap in Marine and Offshore Case Study Slides.pdf" target="blank">
                                                        Allseas Group S.A.
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/World Auto Steel.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="HEED-PDF/103.04 HEEDS EV and HEV - Success Stories.pdf" target="blank">
                                                        World Auto Steel
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/thermolift.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="STAR-CCM+-PDF/Simcenter STAR-CCM+ ThermoLift (Heat Pump Performance) Success Slides.pdf" target="blank">
                                                        ThermoLift develops heat pump that reduces energy costs
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/Amesim.png')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="SIMCENTER-AMESIM-PDF/Simcenter Amesim success stories.pdf" target="blank">
                                                        Simcenter Amesim
                                                        success slides
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="news-card">
                                            <img class="news-img-top" src="{{ asset('assets/images/imagesimcenter/salcomp.jpg')}}" alt="Card image cap">
                                            <div class="news-body">
                                                <p class="news-text">
                                                    <a href="SIMCENTER-MAGNET-PDF/Simcenter MAGNET case studies.pdf" target="blank">
                                                        SALCOMP
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Left and right controls -->
                        <a class="carousel-control-prev  control-prev " href="#demo" data-slide="prev">
                            <i class="fas fa-angle-left" aria-hidden="true"></i>
                        </a>
                        <a class="carousel-control-next control-next" href="#demo" data-slide="next">
                            <i class="fas fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>