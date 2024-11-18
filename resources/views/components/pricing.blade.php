<section class="pt-5 mt-5 pb-5" id="pricing">
    <div class="text-center mt-5">
        <p class="fw-bolder h1" style="font-size: 60px">
            Simple, affordable pricing
        </p>

        <p style="font-size: 20px">Choose a plan that's right for you</p>
    </div>


    <div class="row mb-3 text-center pt-4">
        <div class="col-6 col-md-6 col-lg-3 card-price">

            <div class="card mb-4 p-2 rounded-3 pricing-card" style="height: 22em;">
                <div class="text-start mx-4">
                    <h4 class="fw-bolder">
                        Free
                    </h4>
                    <p>
                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. --}}
                    </p>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p class="
                        h2 fw-bolder mt-4 pt-4*">
                            Free</p>

                    </div>

                </div>
                <div class="card-body mx-auto d-flex flex-column justify-content-center">
                    <ul class="pricing list-unstyled d-flex flex-column align-items-start pb-5">

                        <li>Attendees - 30</li>
                    </ul>
                    @auth
                        <a href="{{ route('wallet-events.index') }}"
                            class="btn btn-block btn-outline-deepOrange mt-5 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @else
                        <a href="{{ route('register') }}"
                            class="btn btn-block btn-outline-deepOrange mt-5 mt-lg-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @endauth
                </div>
            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-3 card-price">

            <div class="card mb-4 p-2 rounded-3 pricing-card" style="height: 22em;">
                <div class="text-start mx-4">
                    <h4 class="fw-bolder">
                        Basic </h4>
                    <p>
                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. --}}
                    </p>

                    <div class="d-flex align-items-center gap-1 justify-content-center">
                        <small class="fw-bolder h5">
                            &#8373 </small>
                        <p class="pt-4">
                            <span class="fw-bolder" style="font-size: 60px">
                                100</span>

                            <small>/ per event</small>
                        </p>
                    </div>
                    <small class="d-flex justify-content-center">
                        Pay As You Go </small>
                </div>
                <div class="card-body mx-auto d-flex flex-column">
                    <ul class="pricing list-unstyled d-flex flex-column align-items-start pb-3">
                        <li>Attendees - 100</li>
                        <li>SMS Credit - 600</li>
                    </ul>
                    @auth
                        <a href="{{ route('wallet-events.index') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder  px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @else
                        <a href="{{ route('register') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @endauth
                </div>

            </div>


        </div>

        <div class="col-6 col-md-6 col-lg-3 card-price">

            <div class="card mb-4 p-2 rounded-3 pricing-card" style="height: 22em;">
                <div class="text-start mx-4">
                    <h4 class="fw-bolder">
                        Standard </h4>
                    <p>
                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. --}}
                    </p>


                    <div class="d-flex align-items-center gap-1 justify-content-center">
                        <small class="fw-bolder h5">
                            &#8373 </small>
                        <p class="pt-4">
                            <span class="fw-bolder" style="font-size: 60px">
                                200</span>
                            <small>/ per event</small>
                        </p>
                    </div>
                    <small class="d-flex justify-content-center">
                        Pay As You Go </small>
                </div>
                <div class="card-body mx-auto d-flex flex-column">
                    <ul class="pricing list-unstyled d-flex flex-column align-items-start pb-3">
                        <li>Attendees - 300</li>
                        <li>SMS Credit - 1800</li>
                    </ul>
                    @auth
                        <a href="{{ route('wallet-events.index') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @else
                        <a href="{{ route('register') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @endauth
                </div>

            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-3 card-price">

            <div class="card mb-4 p-2 rounded-3 pricing-card" style="height: 22em;">
                <div class="text-start mx-4">
                    <h4 class="fw-bolder">
                        Professional </h4>
                    <p>
                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. --}}
                    </p>


                    <div class="d-flex align-items-center gap-1 justify-content-center">
                        <small class="fw-bolder h5">
                            &#8373 </small>
                        <p class="pt-4">
                            <span class="fw-bolder" style="font-size: 60px">
                                500</span>
                            <small>/ per event</small>
                        </p>
                    </div>
                    <small class="d-flex justify-content-center">
                        Pay As You Go </small>
                </div>
                <div class="card-body mx-auto d-flex flex-column">
                    <ul class="pricing list-unstyled d-flex flex-column align-items-start pb-3">
                        <li>Attendees - 1000</li>
                        <li>SMS Credit - 6000</li>
                    </ul>
                    @auth
                        <a href="{{ route('wallet-events.index') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @else
                        <a href="{{ route('register') }}"
                            class="btn btn-block btn-outline-deepOrange mt-4 fw-bolder px-5 px-lg-2 px-xl-5">Get
                            Started</a>
                    @endauth
                </div>

            </div>
        </div>


    </div>
</section>
