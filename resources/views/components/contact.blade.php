<main class="d-flex flex-row align-items-center flex-wrap mt-5  my-0 justify-content-around w-100 h-100  contacts">
    <div>
        <h3 class="text-decoration-underline fw-bold ">Working Hours</h3>
        <p class="fs-4 mt-3">Mondays to Fridays</p>
        <div class="d-flex align-items-center justify-content-center pt-0 gap-3">
            <img width="30px" src={{asset('img/time.svg')}} alt="time">
            <p class="fs-4 mt-3">8am to 5pm</p>
        </div>
    </div>
    <div>
        <h3 class="text-decoration-underline fw-bold ">For Assistance, Call</h3>
        <div class="d-flex align-items-center justify-content-center pt-3 gap-3">
            <img width="30px" src={{asset('img/call.svg')}} alt="call">
            <p class="fs-4 mt-3">0501374686</p>
        </div>
    </div>
    <div>
        <img width="250px" src={{asset('img/service.svg')}} alt="service">
    </div>
</main>

<style>
    /* contacts */

@media (max-width: 576px) {
    .contacts {
        display: flex;
        flex-direction: column !important;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 20px !important;
    }
    .contacts h3{
        font-size: 24px;
    }
}

</style>