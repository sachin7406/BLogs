<section class="wrapper-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="content">
                    <div class="left-side">
                        <div class="address details">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="topic">Address</div>
                            <div class="text-one">Office no SF 643,
                                6th floor, JMD Megapolis ,
                                Sohna Road, Sector -48 Gurugram.
                            </div>
                        </div>
                        <div class="phone details">
                            <i class="fas fa-phone-alt"></i>
                            <div class="topic">Phone</div>
                            <div class="text-one"> +91 - 9350633147, +919810209906</div>

                        </div>
                        <div class="email details">
                            <i class="fas fa-envelope"></i>
                            <div class="topic">Email</div>
                            <div class="text-one">info@ddsplm.com</div>
                            <div class="text-two">marketing@ddsplm.com</div>
                        </div>
                    </div>
                    <div class="right-side">
                        <h2>contact</h2>
                        <form method="POST" action="{{ route('contact.store') }}" class="p-4 shadow rounded bg-white">
                            @csrf

                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="full_name" class="form-control"
                                        placeholder="Enter your full name"
                                        value="{{ old('full_name') }}">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Enter your email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">+91</span>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="10-digit mobile number"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>

                            {{-- Company --}}
                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="text" name="company_name" class="form-control"
                                        placeholder="Your company name"
                                        value="{{ old('company_name') }}">
                                </div>
                            </div>

                            {{-- Solution --}}
                            <div class="mb-3">
                                <label class="form-label">Select Solution</label>

                                <select class="form-select select-control"
                                    name="solution"
                                    id="form_select"
                                    required>
                                    <option value="">Select the Solution</option>

                                    @php
                                    $solutions = [
                                    'simcenter 3d',
                                    'simcenter heeds',
                                    'simcenter motersolve',
                                    'simcenter speed',
                                    'simcenter battery',
                                    'simcenter magnet',
                                    'simcenter femap',
                                    'simcenter amesim',
                                    'simcenter tire',
                                    'captial',
                                    'simcenter starccm+',
                                    'simcenter floefd',
                                    'simcenter flotherm',
                                    'simcenter flomaster',
                                    'simcenter scadas',
                                    'simcenter t3star',
                                    'simcenter teraled',
                                    'rams'
                                    ];
                                    @endphp

                                    @foreach ($solutions as $solution)
                                    <option value="{{ $solution }}"
                                        {{ old('solution') === $solution ? 'selected' : '' }}>
                                        {{ ucfirst($solution) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- Message --}}
                            <div class="mb-4">
                                <label class="form-label">Message</label>
                                <textarea name="message" rows="4" class="form-control"
                                    placeholder="Tell us about your requirement">{{ old('message') }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Send Message 🚀
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>