{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Aerospace & Defence')
@section('meta_description', 'Discover leading solutions for the aerospace and defence industry: engineering innovation, digital transformation, and lifecycle management for modern air and defense platforms.')
@section('meta_keywords', 'Aerospace, Defence, Engineering, Airframes, Avionics, Defense Electronics, Digital Twin, Innovation')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Aerospace & Defence | DDSPLM Industry Solutions')
@section('og_description', 'Explore how DDSPLM advances Aerospace & Defence through digital engineering, collaborative lifecycle management, and cutting-edge industry workflows.')
@section('og_image', asset('assets/images/imagesimcenter/A&D.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Aerospace & Defence | DDSPLM')
@section('twitter_description', 'DDSPLM empowers the Aerospace & Defence sector with advanced engineering, digital transformation, and value chain innovation.')
@section('twitter_image', asset('assets/images/imagesimcenter/A&D.png'))

<!------------------banner--------start---------------------->
<div class="hero-image aerospace-defense">
    <div class="hero-text">
        <h1>Aerospace & Defence</h1>
        <ul class="page-list">
            <li><a class="spa-link" href="/">Home</a></li>
            <li>Aerospace & Defence</li>
        </ul>
    </div>
</div>
<!---------------------banner-------------------end----------------->
<!----simcenter3d------about-----start---->
<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="column column_bg">
                <div class="column_text">
                    <h3>Aerospace & Defence</h3>
                    <p>
                        Aerospace and defense organizations are developing cutting edge platforms and systems with exceptional performance goals. Governments are transforming infrastructure and security systems for new aircraft and technology. The driving force is innovation, facilitated by collaborative, synchronized program management across the aerospace and defense product lifecycle and value chain.
                    </p>
                </div>
            </div>
            <div class="column">
                <img src="{{ asset('assets/images/imagesimcenter/A&D.png')}}" class="img-fluid" alt="A&D">
            </div>
        </div>
    </div>
</section>
<section class="simcenter_3d_accordian_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="simcenter_3d_accordian_text">Industry Segments</h3>
                <button class="accordion active">Aircraft Engines</button>
                <div class="panel show">
                    <p>
                        Aircraft engine OEMs are challenged by the need for increased performance, improved fuel economy and new environmental regulations. They must respond to changing production schedules in a global supply chain and adopt new and innovative materials, structures and systems to achieve higher efficiency, higher performance and quieter engines. Manufacturers must be nimble and flexible to be competitive.
                    </p>
                </div>

                <button class="accordion">Aircraft & Airframes</button>
                <div class="panel">
                    <p>
                        Aircraft companies must launch new and derivative aircraft programs on schedule and budget to be competitive. Demand for improved aircraft performance, production flexibility, reduced operating cost and increased dispatch reliability makes this challenging. These requirements are further complicated by a complex global supply chain of diverse suppliers and partners.
                    </p>
                </div>

                <button class="accordion">Avionics & Defence Electronics</button>
                <div class="panel">
                    <p>
                        With most segments of the aerospace and defense industry expected to grow in the foreseeable future, manufacturers of commercial and military aircraft (manned and unmanned) must continually develop new avionics and electronic systems. They must deliver capabilities that meet all technical and performance requirements at cost and on schedule. This level of program and contract execution requires the ability to design and manufacture products right the first time with as few late changes as possible.
                    </p>
                </div>
                <button class="accordion">Aerospace & Defence Agencies</button>
                <div class="panel">
                    <p>
                        Defense agencies must effectively cope with challenges such as high investment costs in a time of fluctuating budgets, global sourcing, strict contract regulations, and an aging workforce as they acquire and sustain their weapons systems, platforms, and support infrastructure. An integrated digital environment (IDE) that encompasses an entire weapons program, from appropriate contractual methods to supply chain management to quality initiatives, is key to success in the face of these challenges.
                    </p>
                </div>
                <button class="accordion">Space Systems</button>
                <div class="panel">
                    <p>
                        The space systems industry is always looking for ways to build lighter-weight, higher-performance, reusable, and more reliable vehicles as a means of reducing the cost of delivering payloads into orbit. Space exploration has also become an exciting frontier for billionaire investors and other new players looking for ways to reduce the cost of putting payloads into orbit. This requires a strong collaborative digital environment that combines structural, mechanical, systems engineering, environmental testing and program management.
                    </p>
                </div>
                <button class="accordion">Land systems</button>
                <div class="panel">
                    <p>
                        Global unrest and conflict are driving a significant investment in defense systems modernization around the globe as countries are acquiring more capable, technologically advanced and sustainable weapon systems. Although today’s land systems are more complex than previous systems, they must be developed on time and budget while delivering a combination of powertrain, systems and armaments that functions perfectly, first time, every time.

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>