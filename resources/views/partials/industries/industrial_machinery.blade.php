{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Industrial Machinery & Heavy Equipment')
@section('meta_description', 'Explore Siemens solutions for industrial machinery and heavy equipment: enhance innovation, manage complexity, and improve time-to-market with advanced engineering and digitalization.')
@section('meta_keywords', 'Industrial Machinery, Heavy Equipment, Digital Transformation, Engineering, Manufacturing, Simulation, PLM, Siemens')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'Industrial Machinery & Heavy Equipment | DDSPLM')
@section('og_description', 'Discover how DDSPLM and Siemens advance industrial machinery and heavy equipment with integrated digital solutions, helping manufacturers innovate, stay competitive, and optimize operations.')
@section('og_image', asset('assets/images/imagesimcenter/industrial.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'Industrial Machinery & Heavy Equipment | DDSPLM')
@section('twitter_description', 'Power industrial machinery and heavy equipment innovation and engineering with Siemens and DDSPLM advanced solutions.')
@section('twitter_image', asset('assets/images/imagesimcenter/industrial.png'))

<!------------------banner--------start---------------------->
<div class="hero-image industrial-machinery">
    <div class="hero-text">
        <h1>Industrial Machinery & Heavy Equipment</h1>
        <ul class="page-list">
            <li><a class="spa-link" href="/">Home</a></li>
            <li>Industrial Machinery & Heavy Equipment</li>
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
                    <h3>Industrial Machinery & Heavy Equipment</h3>
                    <p>
                        Heavy equipment and industrial machines are more complex than ever. In an increasingly competitive market, companies must ensure innovation and manage complexity. Siemens PLM Software can help you build the right product, and build the product right.
                    </p>
                </div>
            </div>
            <div class="column">
                <img src="{{  asset('assets/images/imagesimcenter/industrial.png')}}" class="img-fluid" alt="efficient automotive design">
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
                <button class="accordion active">Industry Machinery</button>
                <div class="panel">
                    <p>
                        New technology innovation, fierce global competition and demanding customization require industrial machinery manufacturers to continuously innovate and optimize products. Machinery manufacturers must employ advanced multidisciplinary and next-gen design techniques to improve machine performance, reliability and cost of ownership. Virtual simulation and manufacturing capabilities reduce time to delivery and commissioning.
                    </p>
                </div>

                <button class="accordion">Heavy Equipment</button>
                <div class="panel">
                    <p>
                        Heavy equipment manufacturers are developing high-performance machinery with new sensor technology and alternative materials. Along with the need to extend the product life cycle, manufacturers face many challenges: global competition, multi-site manufacturing, compressed development cycles, total cost-of-ownership reductions, fuel economy, and regulatory emissions standards. These challenges require an integrated set of design, simulation and manufacturing tools that are managed in a unified and integrated environment.
                    </p>
                </div>

                <button class="accordion">Mold, Tool & Die</button>
                <div class="panel">
                    <p>
                        Mold, Tool & Die companies face fierce global competition and are looking to design through the production process to reduce tool cost, reduce tool design lead time, and improve product quality. Through accurate costing and shortening lead time, companies can increase job profitability, shop revenue and expand to more complex and customized jobs. Siemens PLM Software can help companies reduce the time taken to produce tooling while meeting quality and cost objectives.
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
                <button class="accordion active">1. Simcenter FloEFD</button>
                <div class="panel">
                    <p>
                        Simcenter FloEFD is a frontload CFD solution, which can be integrated with your CAD tool and perform CFD simulations. Simcenter FloEFD for Electronics industry simulation includes,
                    </p>
                    <ul class="simcenter_accordian_ul">
                        <li>
                            <strong>Heatexchangers</strong> - Analysis of flow distribution and heat transfer problems
                        </li>
                        <li>
                            <strong>Mixing</strong> - Design cavitation and or optimize impeller design
                        </li>
                        <li>
                            <strong>Pumps, fans & Turbines</strong> - Reduce size and optimize performance
                        </li>
                        <li>
                            <strong>Valves</strong> - Reduce size and optimize performance
                        </li>
                        <li>
                            <strong>Pipes, Ducts & Stacks</strong> - Reduce size and optimize performance
                        </li>
                        <li>
                            <strong>External Flows</strong> - Optimize performance by understanding complex flow behaviour
                        </li>
                        <li>
                            <strong>Flow Meters</strong> - Reduce size and optimize performance
                        </li>
                        <li>
                            <strong>Stirred Tanks</strong> - Reduce size and optimize performance
                        </li>
                        <li>
                            <strong>Combustion & Chemical Reaction</strong> - Understand complex flow behaviour
                        </li>
                        <li>
                            <strong>Filters, Cyclones, Separators & Tanks</strong> - Improve operational efficiency
                        </li>
                        <li>
                            <strong>Boilers, Evaporators, Dryers & ovens</strong> - Understand and predict steam flow
                            through tube bundles and flow within heat exchanger headers
                        </li>
                        <li>
                            <strong>Combustion</strong> - Predict combustion performance of fuels and
                            Oxidizers
                        </li>
                    </ul>
                    <a href="./solutions/Simulation/floefd" class="btn btn-primary mb-5">read more</a>
                </div>

                <button class="accordion">2. Simcenter AMESIM</button>
                <div class="panel">
                    <p>
                        Developing industrial machines for packaging, bottle filling, metal forming and textiles requires an optimal balance between various attributes:
                    </p>
                    <ul class="simcenter_accordian_ul">
                        <li>
                            Productivity while reducing production costs
                        </li>
                        <li>
                            Accuracy while limiting the reject rate
                        </li>
                        <li>
                            Reliability while maximizing production time
                        </li>
                        <li>
                            Efficiency while reducing energy costs and complying with environmental regulations
                        </li>
                    </ul>
                    <p>
                        As a consequence, industrial equipment companies have to size multiphysical systems, including hydraulics, pneumatics, electrical, mechanical and thermal, to increase production speed. But this should not impact product quality or the accuracy and reliability of the machine. In addition, tracking energy losses of machines is important to both optimize existing systems and develop new energy efficient ones.
                    </p>
                    <p>
                        In this context, Simcenter Amesim provides you with a set of capabilities to:
                    </p>
                    <ul class="simcenter_accordian_ul">
                        <li>
                            Boost machine productivity by performing multiphysical systems sizing
                        </li>
                        <li>
                            Deliver accuracy and reliability through the simulation of transient behavior
                        </li>
                        <li>
                            Reduce commissioning time by validating and calibrating programmable logic control-ler (PLC)
                        </li>
                        <li>
                            programs using a model of the machine
                        </li>
                        <li>
                            Improve energy efficiency by finding the sources of energy losses
                        </li>
                        <li>
                            Balance energy consumption, productivity and vibration in different operating conditions
                        </li>
                    </ul>
                    <a href="/solutions/Simulation/simcenter-amesim" class="btn btn-primary mb-5">read more</a>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>
<!---------->