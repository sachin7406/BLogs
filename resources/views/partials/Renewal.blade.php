@section('title', 'DDSPLM | Renewal')
@section('meta_description', 'Discover renewal solutions, customer success stories, and support for ongoing engineering excellence from DDSPLM. Stay current on updates, renewals, and latest offerings to maximize your product value.')
@section('meta_keywords', 'renewal, engineering renewal, DDSPLM renewal, product renewal, software renewal, support, service renewal, CAD renewal, CAE renewal, PLM renewal, Siemens, Altair')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'DDSPLM | Renewal & Support Solutions')
@section('og_description', 'Explore renewal resources and ongoing support offerings from DDSPLM. Ensure your engineering tools and solutions remain up to date for maximum productivity and innovation.')
@section('og_image', asset('images/no-image-available.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'DDSPLM | Engineering Renewal & Support')
@section('twitter_description', 'DDSPLM provides renewal services, support solutions, and expertise to ensure your engineering software and products stay current and fully supported.')
@section('twitter_image', asset('images/no-image-available.png'))

<div class="hero-image">
    <div class="hero-text">
        <h1>Renewal</h1>
        <ul class="page-list">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>Renewal</li>
        </ul>
    </div>
</div>
<!---banner- end--->

<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 column_bg">
                <div class="column_text">
                    <h3>Boosting design efficiency with prepackaged high-performance CAD solutions</h3>
                    <p>
                        The NX Design software offerings are comprehensive solutions that provide the advanced computer-aided design (CAD) functionalities of NX software, which is a premier choice for mechanical design.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png')}}" class="img-fluid" alt="efficient automotive design">
            </div>
        </div>
    </div>
</section>

<section class="renewal-section py-5">
    <div class="container">
        <!-- Title and Intro -->
        <div class="simcenter_3d_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 shadow p-5 bg-light rounded">
                        <h3 class="mb-3">Maintenance, Enhancements, and Support</h3>
                        <p>
                            Renewals maximize the value of your investment through comprehensive maintenance and support agreements. Ensuring your teams have access to the latest product features, timely upgrades, and personalized assistance is essential for ongoing productivity and innovation. Our support resources connect you to skilled engineers and fast solutions, making it easy to stay current and competitive.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits List -->
        <div class="row mb-5">
            <div class="col-md-12 col-sm-6 cgfc-box-2">
                <div class="column_text">
                    <h3>Benefits of Renewal</h3>
                    <ul class="simcenter_3d_ul">
                        <li>
                            <strong>Significant software releases featuring new capabilities and functions</strong> – New releases deliver the latest features and the most effective tools for optimal product lifecycle management.
                        </li>
                        <li>
                            <strong>Update releases</strong> – Updates are provided as necessary between major software releases, offering software enhancements as swiftly as possible. Update releases do not involve alterations in data architecture. These releases keep your teams informed about ongoing product innovations and improvements, thereby enhancing their productivity by utilizing the most current functionalities.
                        </li>
                        <li>
                            <strong>Expert technical support resources available whenever and however you require them</strong> – Technical support can be accessed through our comprehensive, personalized online support site or by direct communication with a support engineer.
                        </li>
                        <li>
                            <strong>24/7 online support site access</strong> – Our online support site provides 24/7 access, allowing you to quickly find the answers you need.
                        </li>
                        <li>
                            <strong>Regular technical communications</strong> – Regular technical communications to keep you informed about the latest knowledge-base articles and product announcements relevant to your products or areas of interest. We offer various email communications to ensure you stay updated on the latest technical content and special opportunities related to the products you utilize.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Siemens Xcelerator as a Service Section -->
        <section class="simcenter_3d_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-6 cgfc-box-2">
                        <div class="column_text">
                            <h3>Siemens Xcelerator as a Service is the all-access pass to a digital future</h3>
                            <ul class="simcenter_3d_ul">
                                <li>
                                    Start enjoying all the benefits of a more accessible digital transformation with Siemens Xcelerator as a Service.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Perpetual to XAAS Section -->
        <section class="simcenter_3d_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <h4 class="mb-3">What is Perpetual to XAAS?</h4>
                        <div class="text-center mb-3">
                            <img src="{{ asset('assets/images/perpetual-to-xaas-table.png') }}" alt="Perpetual to XAAS comparison table" class="img-fluid" style="max-width:100%; box-shadow: 0 2px 16px #00000017;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>