{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Medical Devices')
@section('meta_description', 'Explore Siemens solutions for the medical device and pharmaceutical industries: accelerate innovation, ensure compliance, reduce costs, and enhance product development with PLM.')
@section('meta_keywords', 'Medical Devices, Pharmaceuticals, PLM, Siemens, Product Lifecycle Management, FDA Compliance, Innovation, Manufacturing, Engineering')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Medical Devices | DDSPLM Industry Solutions')
@section('og_description', 'Siemens and DDSPLM empower medical device and pharma companies with digital PLM, streamlined product development, and compliance to regulations like FDA.')
@section('og_image', asset('assets/images/imagesimcenter/medical.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Medical Devices | DDSPLM')
@section('twitter_description', 'Advance medical device innovation, quality, and compliance with DDSPLM and Siemens PLM solutions for pharma and life sciences.')
@section('twitter_image', asset('assets/images/imagesimcenter/medical.png'))

<!----------------------banner-------------start------------------>
<div class="hero-image medical-devices">
    <div class="hero-text">
        <h1>Medical Devices</h1>
        <ul class="page-list">
            <li><a class="spa-link" href="/">Home</a></li>
            <li>Medical Devices</li>
        </ul>
    </div>
</div>
<!---banner- end--->
<!----simcenter3d------about-----start---->
<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="column column_bg">
                <div class="column_text">
                    <h3>Medical Devices</h3>
                    <p>
                        Siemens Digital Industries Software offers solutions for leading companies in the medical device and pharmaceutical industries that recognize the need for a product lifecycle management (PLM) platform to answer product development challenges. Our proven, flexible solutions help speed up innovation in the pharmaceutical and medical device development, ensure quality, reduce costs and maintain adherence to ever-changing global regulations, including FDA compliance.
                    </p>
                </div>
            </div>
            <div class="column">
                <img src="{{  asset('assets/images/imagesimcenter/medical.png')}}" class="img-fluid" alt="efficient automotive design">
            </div>
        </div>
    </div>
</section>
<!----simcenter3d------about-----end------>

<!----simcenter_3d_accordian_section-----start---->
<section class="simcenter_3d_accordian_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="simcenter_3d_accordian_text">Industry Segments</h3>
                <button class="accordion active">1. Cardiovascular & Neurological</button>
                <div class="panel">
                    <P>
                        Speed to market, quality, cost effectiveness and compliance are all factors affecting today's cardiovascular and neurological medical device markets. Equip your organization with our intelligent solutions to design, develop and manufacture via a seamless multidisciplinary platform and emerge as an industry leader.

                    </p>
                </div>

                <button class="accordion">2. Medical Instruments & Equipment</button>
                <div class="panel">
                    <p>
                        Increasingly consumer-centric and personalized healthcare therapies demand innovative design and manufacturing of medical instruments and equipment. Our solutions provide an integrated set of multidisciplinary, mechatronic engineering and manufacturing capabilities, offering faster and easier updates and refinements while on the path to regulatory approval or in production. Innovate with speed and confidence knowing that your design, development, and manufacturing environments will produce cutting-edge medical devices.
                    </p>
                </div>

                <button class="accordion">3. Orthopedics & Dental</button>
                <div class="panel">
                    <p>
                        The ability to innovate continuously, and with the speed and confidence that your medical device design and manufacturing environment requires, is critical in today’s complex and competitive marketplace. Our solutions for orthopedic and dental device manufacturers provide solutions for personalized and traditional therapies that incorporate innovative design and “smart” manufacturing and technology platforms.
                    </p>
                </div>
                <button class="accordion">4. Pharmaceuticals</button>
                <div class="panel">
                    <p>
                        Our solution portfolio for pharmaceutical manufacturers addresses the complexities of global configuration management of varied formulations and packaging, including the ability to simulate manufacturing processes to optimize quality and production yields. Along with our extensive medical device industry solution portfolio, we deliver comprehensive end-to-end solutions for combination products and devices.
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!---------->