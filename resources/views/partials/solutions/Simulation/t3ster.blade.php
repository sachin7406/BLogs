{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | SIMCENTER T3STER')
@section('meta_description', 'Discover Simcenter T3STER: Advanced non-destructive transient thermal tester for fast, accurate thermal characterization of semiconductor devices and packages.')
@section('meta_keywords', 'Simcenter T3STER, Thermal Tester, Transient Measurement, Semiconductor Devices, Thermal Characterization, Structure Function, Siemens')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Simcenter T3STER | Advanced Thermal Tester by Siemens')
@section('og_description', 'Simcenter T3STER delivers high-accuracy, non-destructive transient thermal testing and structure function analysis for semiconductor and multi-die device modeling and validation.')
@section('og_image', asset('assets/images/imagesimcenter/T3star.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Simcenter T3STER | Siemens Thermal Tester')
@section('twitter_description', 'Simcenter T3STER: Fast and precise thermal test for semiconductor package analysis and simulation model calibration.')
@section('twitter_image', asset('assets/images/imagesimcenter/T3star.png'))

<!--banner-->
<div class="hero-image t3ster">
    <div class="hero-text">
        <h1>SIMCENTER T3STER</h1>
        <ul class="page-list">
            <li><a href="/" class="spa-link">Home</a></li>
            <li>SIMCENTER T3STER</li>
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
                    <h3>SIMCENTER T3STER</h3>
                    <p>
                        Simcenter T3STER is an advanced non-destructive transient thermal tester for thermal characterization of packaged semiconductor devices (diodes, BJTs, power MOSFETs, IGBTs, power LEDs) and multi-die devices. It measures the true thermal transient response more efficiently than steady-state methods. Measurements are to ±0.01° C with up to 1-microsecond time resolution. Structure functions post-process the response into a plot that shows the thermal resistance and capacitance of package features along the heat flow path. Simcenter T3STER is an ideal pre- and post-stress failure detection tool. The measurements can be exported for thermal model calibration, underpinning the accuracy of the thermal design effort.
                    </p>
                    <!-- <a href="contact.html"class="btn btn-link">contact</a> -->
                </div>
            </div>
            <div class="column">
                <img src="{{  asset('assets/images/imagesimcenter/T3star.png')}}" class="img-fluid" alt="Simcenter T3STER">

            </div>
        </div>

    </div>
</section>
<!----simcenter3d------about-----end------>