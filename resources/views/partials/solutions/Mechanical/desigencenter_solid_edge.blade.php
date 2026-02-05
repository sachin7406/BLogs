{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Solid Edge Design Center')
@section('meta_description', 'Discover Siemens Solid Edge for advanced mechanical design: innovate with powerful 3D CAD, generative design, reverse engineering, and additive manufacturing—all in an intuitive environment.')
@section('meta_keywords', 'Solid Edge, Siemens, mechanical CAD, 3D design, product innovation, generative design, synchronous technology, reverse engineering, additive manufacturing, product development, CAD software')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Solid Edge | Advanced Mechanical Design Solutions')
@section('og_description', 'Explore Siemens Solid Edge for powerful CAD: innovate, design, and develop products efficiently with intuitive modeling, generative design, reverse engineering, and additive manufacturing.')
@section('og_image', asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Solid Edge | Siemens CAD Solutions')
@section('twitter_description', 'Discover Siemens Solid Edge—advance your product development cycle with leading 3D CAD, generative and additive design, and reverse engineering tools.')
@section('twitter_image', asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png'))

<!------------------banner--------start---------------------->
<div class="hero-image Automotive-EV">
    <div class="hero-text">
        <h1>Solid Edge – Powerful CAD by Siemens</h1>
        <ul class="page-list">
            <li><a class="spa-link" href="/">Home</a></li>
            <li>Design Center</li>
            <li>Solid Edge</li>
        </ul>
    </div>
</div>
<!---banner- end--->


<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="column column_bg">
                <div class="column_text">
                    <h3>Designcenter Solid Edg</h3>
                    <p>
                        Solid Edge mechanical design software stands as a leading 3D computer-aided design (CAD) application in the market, facilitating the future of product development through features such as generative design, reverse engineering, and design for additive manufacturing.
                    </p>
                    <p>
                        These advanced techniques are effortlessly combined with traditional methods, thanks to Convergent Modeling™ and enhanced by unique synchronous technology within the industry. The robust environment for part, assembly, and drawing design, developed over decades, integrates flawlessly with a suite of affordable and user-friendly software tools that cover every facet of the product development process. This integration allows for a seamless transition from 3D mechanical design to electrical design, simulation, manufacturing, and beyond, all supported by integrated data management throughout the journey
                    </p>
                </div>
            </div>
            <div class="column">
                <img src="{{ asset('assets/images/imagesimcenter/FASTER, MORE EFFICIENT AUTOMOTIVE DESIGN.png')}}" class="img-fluid" alt="efficient automotive design ">
            </div>
        </div>
    </div>
</section>

<section class="simcenter_3d_accordian_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Intro Card -->
                <div class="shadow p-5 bg-light rounded mb-4">
                    <h4>Next-Generation Design</h4>
                    <p>
                        Solid Edge seamlessly integrates advanced design methodologies into your development process, empowering you to innovate within your industry.
                    </p>
                    <p>
                        Synchronous technology enables rapid concept creation, easy change management, and direct editing of imported 3D CAD data as if it were native. It allows simultaneous updates across assembly components and combines the speed of direct modeling with the precision of history-based design in a single, unified environment.
                    </p>
                </div>

                <button class="accordion active">Benefits</button>
                <div class="panel show">
                    <ul class="dot-list">
                        <li>User-friendly interface for rapid value realization</li>
                        <li>Advanced design tools that enable disruptive innovation</li>
                        <li>Proven expertise in core 3D CAD for complex design challenges</li>
                        <li>Streamlines product design to reduce overall costs</li>
                        <li>3D visualization and validation for improved design quality</li>
                        <li>Integrated applications supporting design through manufacturing</li>
                    </ul>
                </div>

                <!-- Accordion 1 -->
                <button class="accordion">Solid Edge Core 3D CAD Solution</button>
                <div class="panel show">
                    <p>
                        Solid Edge accelerates time-to-market while reducing engineering costs. Its powerful part and assembly modeling, flexible drafting, advanced sheet metal tools, and high-end visualization deliver a fast, adaptable, and efficient design experience.
                    </p>
                </div>

                <!-- Accordion 2 -->
                <button class="accordion">3D Part Modeling</button>
                <div class="panel">
                    <p>
                        Solid Edge enables fast and flexible modeling of virtually any component. Automated tools support gears, cams, springs, beams, and more.
                    </p>
                    <p>
                        Advanced surface modeling supports complex shapes, while dedicated plastic part tools and stylus-based sketching transform rough concepts into precise geometry. Goal Seek automation resolves complex positioning and fitting challenges efficiently.
                    </p>
                </div>

                <!-- Accordion 3 -->
                <button class="accordion">Sheet Metal Design</button>
                <div class="panel">
                    <p>
                        Solid Edge delivers industry-leading sheet metal design capabilities, supporting the entire design-to-fabrication workflow. It ensures manufacturability while optimizing flat patterns, drawings, and production outputs.
                    </p>
                </div>

                <!-- Accordion 4 -->
                <button class="accordion">Drawing and Drafting</button>
                <div class="panel">
                    <p>
                        Drawing creation from 3D models is enhanced through automatic update notifications and built-in change tracking. AI-powered drawing generation provides intelligent view placement, dimensioning, and standards compliance with high performance.
                    </p>
                </div>

                <!-- Accordion 5 -->
                <button class="accordion">Assembly Modeling and Management</button>
                <div class="panel">
                    <p>
                        Solid Edge efficiently handles assemblies of any size, from initial layout to full digital mockups. Features include interference detection, in-context modeling, and automatic high-performance mode for large assemblies.
                    </p>
                    <p>
                        AI-assisted assembly identifies optimal constraints automatically, enabling faster and more accurate component placement.
                    </p>
                </div>

                <!-- Accordion 6 -->
                <button class="accordion">Standard Part Library</button>
                <div class="panel">
                    <p>
                        Solid Edge provides a powerful parts management system for standard components such as fasteners, bearings, structural members, pipes, and fittings. Pre-populated libraries help reduce inventory complexity and accelerate accurate assembly.
                    </p>
                </div>

                <!-- Accordion 7 -->
                <button class="accordion">2.5 Axis Milling</button>
                <div class="panel">
                    <p>
                        Solid Edge CAM Pro 2.5 Axis delivers comprehensive milling capabilities integrated with Solid Edge Classic, Foundation, and Premium editions.
                    </p>
                    <p>
                        Full associativity with design data, automated toolpath generation, and visual verification ensure optimized and reliable machining workflows.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>