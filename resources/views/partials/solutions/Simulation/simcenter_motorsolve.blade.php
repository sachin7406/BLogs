{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Simcenter Motorsolve')
@section('meta_description', 'Discover Simcenter Motorsolve: Advanced electric machine design and analysis. Simulate, analyze, and optimize permanent magnet, induction, synchronous, electronically and brush-commutated motors with intuitive FEA-driven tools.')
@section('meta_keywords', 'Simcenter Motorsolve, Electric Machine Design, FEA, Motor Simulation, Siemens, EV Motor Design, Electromagnetic Analysis, Permanent Magnet, Motor Topology, Induction Machine, Synchronous Machine')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Simcenter Motorsolve | Electric Machine Design & FEA Simulation')
@section('og_description', 'Simcenter Motorsolve advances the electric machine R&D with rapid, accurate motor simulation and analysis. Boost performance through accurate field plots, intuitive templates, and automated workflows.')
@section('og_image', asset('assets/images/imagesimcenter/Motorsolve.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Simcenter Motorsolve | Electric Machine Design & FEA Simulation')
@section('twitter_description', 'Simcenter Motorsolve: Comprehensive software for advanced electric machine modeling, simulation, and optimization with robust FEA tools and automated workflows.')
@section('twitter_image', asset('assets/images/imagesimcenter/Motorsolve.png'))

<div class="hero-image">
    <div class="hero-text">
        <h1>SIMCENTER MOTORSOLVE</h1>
        <ul class="page-list">
            <li><a href="/" class="spa-links">Home</a></li>
            <li>SIMCENTER MOTORSOLVE</li>
        </ul>
    </div>
</div>
<!-------------banner----------end-------------->
<!----simcenter3d------about-----start---->
<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="column column_bg">
                <div class="column_text">
                    <h3>SIMCENTER MOTORSOLVE</h3>
                    <p>
                        Simcenter Motor solve is a complete design and analysis solution for permanent magnet, induction, synchronous, electronically, and brush-commutated machines. The software leverages finite element analysis with an intuitive interface for accurate simulations of electric machines.
                    </p>
                    <p>
                        The template-based interface is easy to use and flexible enough to handle practically any motor topology, with provision for custom rotors and stators. Typical FEA operations such as mesh and solver refinements, winding layout and post-processing (including the export of 1D models) are automated by the software. Performance parameters, waveforms, and field plots are available with just a mouse click.
                    </p>
                    <!-- <a href="../../../contact.html"class="btn btn-link">contact</a> -->
                </div>
            </div>
            <div class="column">
                <img src="{{  asset('assets/images/imagesimcenter/Motorsolve.png')}}" class="img-fluid" alt="modeling">
            </div>
        </div>

    </div>
</section>
<!----simcenter3d------about-----end------>
<!----simcenter3d------about-----start---->
<section class="simcenter_3d_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-6 cgfc-box-2">
                <div class="column_text">
                    <h3>Simcenter Motorsolve Features</h3>
                    <ul class="simcenter_3d_ul">
                        <li>
                            Automatically calculates list of all balanced windings
                        </li>
                        <li>
                            Auto-size: Get an initial value for several parameters related to the size of the machine based on torque per unit volume or rated current density
                        </li>
                        <li>
                            Pre-defined library of linear, nonlinear and anisotropic materials
                        </li>
                        <li>
                            Fully coupled drive-electromagnetic-mechanical-thermal simulations
                        </li>
                        <li>
                            Coupled Electromagnetic and Thermal effects
                        </li>
                    </ul>
                </div>
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
                <button class="accordion active">ELECTRIC MOTOR COIL WINDING</button>
                <div class="panel">
                    <p>
                        The electric motor coil winding layout plays a central role in design and performance. The technology used to determine the complete list of all possible balanced layouts is unique and makes evaluating alternatives easy. All the relevant factors are automatically calculated. Any predetermined layout can be modified or the coil winding can be entered manually. An extensive list of winding charts is available (Phase Back-EMF, Gorges diagram, Air gap MMF, and more).
                    </p>
                    <i"mg src={{  asset('assets/images/simcenter/ELECTRIC MOTOR COIL WINDING.png')}}" class="img-fluid d-block mx-auto p-5" style="height:400px">
                </div>
                <button class="accordion">ELECTRIC MOTOR TYPES</button>
                <div class="panel">
                    <p>
                        Complete electric motor design software for permanent magnet, induction, synchronous, electronically, and brush-commutated machines. The template-based interface is easy to use and flexible enough to handle practically any motor topology. Custom rotor and stator profiles can be imported.
                    </p>
                    <img src="{{  asset('assets/images/simcenter/simcenter electric motor software motor types.png')}}" class="img-fluid d-block mx-auto p-5" style="height:400px">
                </div>
                <button class="accordion">FEA AUTOMATION</button>
                <div class="panel">
                    <p>
                        A more efficient electric motor design process with the automation of typical FEA pre and post-processing tasks. Typical FEA operations, such as mesh refinements, solution space definition, and post-processing, are not required. Virtual experiments and export of 1D models are also preset for the user.
                    </p>
                    <img src="{{  asset('assets/images/simcenter/FEA AUTOMATION.png')}}" class="img-fluid d-block mx-auto p-5" style="height:400px">
                </div>
                <button class="accordion">MOTOR THERMAL ANALYSIS</button>
                <div class="panel">
                    <p>
                        Seamless co-simulation between electromagnetic and thermal analysis for electric motors to study the effects of heat and various cooling strategies on performance. Using a robust and highly proficient automated 3D FEA engine, performance results can be based on steady-state or transient temperature analysis.
                    </p>
                    <img src="{{  asset('assets/images/simcenter/MOTOR THERMAL ANALYSIS.png')}}" class="img-fluid d-block mx-auto p-5" style="height:400px">
                </div>
                <button class="accordion">PERFORMANCE ANALYSIS</button>
                <div class="panel">
                    <p>
                        Use preset virtual experiments to evaluate the simulated performance of electric motors. The experiments yield output quantities, waveforms, fields, and charts. The virtual experiments include analysis over the whole torque-speed curve, thermal performance, motor characterization, instantaneous waveforms, and hotspots.
                    </p>
                    <img src="{{  asset('assets/images/simcenter/PERFORMANCE ANALYSIS.png')}}" class="img-fluid d-block mx-auto p-5" style="height:400px">
                </div>
            </div>
        </div>
    </div>
</section>
<!----simcenter_3d_accordian_section-----end------>