{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Electronics')
@section('meta_description', 'Explore Siemens Capital software and digital solutions for the electronics industry: streamline E/E systems, electronic product design, and manufacturing with an integrated digital twin.')
@section('meta_keywords', 'Electronics, Electronic Design, E/E Systems, Capital, Siemens, Digital Twin, Product Innovation, Electronics Manufacturing, Embedded Systems')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Electronics | DDSPLM Industry Solutions')
@section('og_description', 'DDSPLM empowers electronics companies with advanced E/E systems, design automation, and manufacturing digitalization powered by Siemens Capital and comprehensive digital twin technology.')
@section('og_image', asset('assets/images/imagesimcenter/industrial.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Electronics | DDSPLM Industry Solutions')
@section('twitter_description', 'Accelerate innovation and product excellence in electronics with DDSPLM digital solutions and Siemens Capital for E/E systems engineering.')
@section('twitter_image', asset('assets/images/imagesimcenter/industrial.png'))

<!------------------------banner--------------------------start----------------->
<div class="hero-image electronic">
    <div class="hero-text">
        <h1>Electronics</h1>
        <ul class="page-list">
            <li><a class="spa-link" href="/">Home</a></li>
            <li>Electronics</li>
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
                    <h3>Gain a competitive advantage in electronic systems design to dramatically improve your business?</h3>
                    <p>
                        The electronics industry is characterized by extremely short product life cycles. That is why a smart concept is needed – one that is intelligently adapted to this innovation-driven market. With the comprehensive Digital Enterprise portfolio: product designers, electronics manufacturers and machine builders can find the right hardware and software to meet any challenge.
                    </p>
                </div>
            </div>
            <div class="column">

                <img src="{{  asset('assets\images\imagesimcenter\Consumer.png')}}" class="img-fluid" alt="efficient automotive design">

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
                <button class="accordion active">Consumer & Industrial Electronics</button>
                <div class="panel">
                    <p>
                        Our Digital Enterprise Platform is based on an open, scalable, secure and future-proof architecture. Our solutions help consumer and industrial electronics companies achieve real business value by helping them get to market faster and reduce costs while improving quality and market position.
                    </p>
                </div>

                <button class="accordion">Electronic Manufacturing Services</button>
                <div class="panel">
                    <p>
                        Value chain partners providing contracted manufacturing and logistics to electronics OEMs
                    </p>
                </div>

                <button class="accordion">Semiconductor Devices</button>
                <div class="panel">
                    <p>
                        All semiconductor companies (fabs, fabless, IDMs, foundries, OSATs or subcons, and photonics) can use state-of-the-art software solutions for the semiconductor industry from Siemens to drive innovation and increase productivity. Overcome today's challenges while transforming your business into the digital enterprise of tomorrow with edge-to-edge solutions covering all aspects of the semiconductor device (IC, Chip) lifecycle, from concept to design, through production to operations and optimized service lifecycle management.
                    </p>
                </div>
                <button class="accordion">Semiconductor Equipment</button>
                <div class="panel">
                    <p>
                        Equipment and services to enable the production of semiconductor devices
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!---------->
<!----simcenter_3d_accordian_section-----start---->
<section class="simcenter_3d_accordian_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="simcenter_3d_accordian_text">Solution Segment</h3>
                <button class="accordion active">Simcenter FloEFD</button>
                <div class="panel">
                    <p>
                        Simcenter FloEFD is a frontload CFD solution, which can be integrated with your CAD tool and perform CFD simulations. Simcenter FloEFD for Electronics industry simulation includes,
                    </p>
                    <ul class="simcenter_accordian_ul">
                        <li>
                            <strong>Fan Sizing & placement</strong> - choose correct fan sizing to overcome system pressure drop and ensure the fan operates on the correct part of the fan curve
                        </li>
                        <li>
                            <strong>Heatsink Design & Selection</strong> - select the most suitable heat sink for a specific application to minimize cost, weight and pressure drop whilst meeting temperature
                        </li>
                        <li>
                            <strong>Power Electronics</strong> - Sufficiently cool power electronics to ensure operational performance
                        </li>
                        <li>
                            <strong>Cold Plates & Liquid Cooling </strong> - use liquid as the primary cooling medium due to increased power density or cost-effectiveness
                        </li>
                        <li>
                            <strong>Vent Sizing & Location</strong> - Optimize the rate and uniformity of system-level air flow through placement and size of vents
                        </li>
                        <li>
                            <strong>Air Flow Optimization</strong> - Optimize air flow by identifying obstructions such as connectors and heatsinks
                        </li>
                        <li>
                            <strong>Joule Heating</strong> - Joule heating in traces can cause additional voltage drop, trace de-lamination, and even melting of the dielectric
                        </li>
                        <li>
                            <strong>Case & Junction Temperature Prediction </strong> - Meet specification, whether it’s a power package, LED, microprocessor or ASIC by evaluating detailed and compact thermal package models to predict junction and case temperature during design
                        </li>
                        <li>
                            <strong>Enclosure Thermal Design</strong> - to ensure temperature limits are not exceeded and prevent dust ingress
                        </li>
                        <li>
                            <strong>Heatpipes</strong> - Heatpipes are used to transport heat from the source to a heat rejection area or reduce temperature gradients in a heat spreader
                        </li>
                        <li>
                            <strong>Lighting </strong> - Ensure adequate cooling of light bulbs accounting for conduction, convection and radiation losses

                        </li>
                    </ul>
                    <img src="{{ asset('assets\images\simcenter\Mentor-Graphics-FloEFD_2.jpg')}}" class="img-fluid d-block mx-auto p-5" alt="Mentor-Graphics-FloEFD_2" style="height:auto;">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!---------->