@extends('layout.admin');

@section('content')
    <section id="home">
        <div class="row">
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-globe text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total Users</p>
                                    {{-- <p class="card-title">{{ $statistics['events'] }}</p> --}}
                                    <p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total Revenue</p>
                                    {{-- <p class="card-title">{{ $statistics['ongoing_events'] }}</p> --}}
                                    <p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-vector text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category text-nowrap">Montly Events</p>
                                    {{-- <p class="card-title">{{ $statistics['upcoming_events'] }}</p> --}}
                                    <p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-favourite-28 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Upcoming Events</p>
                                    {{-- <p class="card-title">{{ $statistics['first_for_users_events'] }}</p> --}}
                                    <p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="pt-5 mt-5 card text-center">

            <div class="px-5">
                <h5 class="text-secondary">
                    Events per week
                </h5>
                <canvas id="myChart" class="pb-5"></canvas>

            </div>
        </div>
    </section>
@endsection


@section('script')
    <script>
        const labels = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',

        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'First week',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45],
            }, {
                label: 'Second week',
                backgroundColor: 'rgb(0,161,255)',
                borderColor: 'rgb(0,161,255)',
                data: [0, 30, 5, 2, 45, 30, 70],
            }],

        };

        const config = {
            type: 'line',
            data: data,
        };




        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endsection
