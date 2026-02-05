{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Simcenter TERALED')
@section('meta_description', 'Discover Simcenter TERALED: Integrated LED measurement solution for advanced electrical, thermal, and radiometric/photometric characterization in lighting applications.')
@section('meta_keywords', 'Simcenter TERALED, LED Testing, Thermal Characterization, LED Modules, Photometric Testing, Siemens, Thermal Resistance, Lighting Design, JEDEC JESD51-52, CIE 127:2007, CIE 225:2017')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Simcenter TERALED | Advanced LED Characterization & Testing')
@section('og_description', 'Simcenter TERALED and T3STER enable comprehensive, automated LED testing—electrical, thermal, and photometric—supporting accurate lighting design and modeling.')
@section('og_image', asset('assets/images/imagesimcenter/Teraled.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Simcenter TERALED | Advanced LED Measurement')
@section('twitter_description', 'Industry-proven LED testing platform for electrical, thermal, and photometric property measurement—Simcenter TERALED in combination with T3STER.')
@section('twitter_image', asset('assets/images/imagesimcenter/Teraled.png'))

<!--banner-->
<div class="hero-image teraled">
    <div class="hero-text">
        <h1>SIMCENTER TERALED</h1>
        <ul class="page-list">
            <li><a href="/" class="spa-links">Home</a></li>
            <li>SIMCENTER TERALED</li>
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
                    <h3>SIMCENTER TERALED</h3>
                    <p>
                        Together with Simcenter T3STER thermal characterization hardware, Simcenter TERALED temperature-controlled test stage, forms a combined electrical, thermal, and radiometric/photometric testing station for LEDs and LED modules, creating multi-domain compact models that can be used in Simcenter thermal design software. These LED testing solutions conform to the JEDEC JESD51-52 standard and follow CIE technical reports 127:2007 and 225:2017. Real thermal resistance and light output metrics are measured as a function of real LED junction temperature over a wide range of forwarding current. The process is fully automated. Third party spectroradiometers help capture emission spectra, providing further input for precise modeling of LED package light output properties in lighting design.
                    </p>
                    <!-- <a href="../../contact.html"class="btn btn-link">contact</a> -->
                </div>
            </div>
            <div class="column">
                <img src="{{  asset('assets/images/imagesimcenter/Teraled.png')}}" class="img-fluid" alt="Simcenter T3STER">
            </div>
        </div>

    </div>
</section>
<!----simcenter3d------about-----end------>