@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="card mt-3">
            <div class="card-body">

                @if (session('success'))
                    @section('alertify-script')
                        <script>
                            alertify.success("{{ session('success') }}");
                        </script>
                    @show
                @elseif (session('failure'))
                    @section('alertify-script')
                        <script>
                            alertify.error("{{ session('failure') }}");
                        </script>
                    @show
                @endif


            


                <div class="row">
                    <div class="col-md-2">
                        <div class="d-flex align-items-center bg-white border rounded-sm overflow-hidden shadow">
                            <div
                                class="p-4 bg-white d-flex justify-content-center align-items-center rounded-sm overflow-hidden shadow">
                                <img src="{{ asset('icons/application.png') }}" alt="Goat Icon"
                                    style="height: 30px; width: 32px;">
                            </div>
                            <div class="px-4 text-gray-700">
                                <h5 class="text-sm tracking-wider"> Categories</h5>
                                <p class="text-3xl"></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex  align-items-center bg-white border rounded-sm overflow-hidden shadow">
                            <div
                                class="p-4 bg-white d-flex justify-content-center align-items-center rounded-sm overflow-hidden shadow">
                                <img src="{{ asset('icons/categorization.png') }}" alt="Goat Icon"
                                    style="height: 30px; width: 32px;">
                            </div>
                            <div class="px-4 text-gray-700">
                                <h5 class="text-sm tracking-wider"> Sub Categories</h5>
                                <p class="text-3xl"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- <script>
    function updateCharts(selectedType) {
        var updatedData = [];
        if (selectedType === 'goat') {
            updatedData = [{{ $goatCount }}, 0, {{ $maleCount }}, {{ $femaleCount }},
                {{ $goatBreederCount }}, {{ $goatPregnantCount }}, {{ $kidsCount0to3 }},
                {{ $kidsCount3to6 }}, {{ $kidsCount6to9 }}
            ];
        } else if (selectedType === 'cow') {
            updatedData = [0, {{ $cowCount }}, {{ $maleCount }}, {{ $femaleCount }},
                {{ $cowBreederCount }}, {{ $cowPregnantCount }}, {{ $kidsCount0to3 }},
                {{ $kidsCount3to6 }}, {{ $kidsCount6to9 }}
            ];
        }

        pieChart.data.datasets[0].data = updatedData;
        pieChart.update();
        barChart.data.datasets[0].data = updatedData;
        barChart.update();
        lineChart.data.datasets[0].data = updatedData;
        lineChart.update();
    }

    document.getElementById('animalType').addEventListener('change', function() {
        var selectedType = this.value;
        updateCharts(selectedType);
    });

    var pieChartData = {
        labels: ['Goats', 'Cows', 'Males', 'Females', 'Breeders', 'Pregnant', 'Kids 0-3', 'Kids 3-6', 'Kids 6-9'],
        datasets: [{
            data: [{{ $goatCount }}, 0, {{ $maleCount }}, {{ $femaleCount }},
                {{ $goatBreederCount }}, {{ $goatPregnantCount }}, {{ $kidsCount0to3 }},
                {{ $kidsCount3to6 }}, {{ $kidsCount6to9 }}
            ],
            backgroundColor: ['red', 'green', 'blue', 'purple', 'orange', 'pink', 'yellow', 'cyan', 'magenta'],
        }],
    };

    var pieCtx = document.getElementById('animalPieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: pieChartData,
    });

    var barChartData = {
        labels: ['Goats', 'Cows', 'Males', 'Females', 'Breeders', 'Pregnant', 'Kids 0-3', 'Kids 3-6', 'Kids 6-9'],
        datasets: [{
            label: 'Animal Counts',
            data: [{{ $goatCount }}, 0, {{ $maleCount }}, {{ $femaleCount }},
                {{ $goatBreederCount }}, {{ $goatPregnantCount }}, {{ $kidsCount0to3 }},
                {{ $kidsCount3to6 }}, {{ $kidsCount6to9 }}
            ],
            backgroundColor: ['red', 'green', 'blue', 'purple', 'orange', 'pink', 'yellow', 'cyan', 'magenta'],
        }],
    };

    var barCtx = document.getElementById('animalBarChartCanvas').getContext('2d');
    var barChart = new Chart(barCtx, {
        type: 'bar',
        data: barChartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    var lineChartData = {
        labels: ['Goats', 'Cows', 'Males', 'Females', 'Breeders', 'Pregnant', 'Kids 0-3', 'Kids 3-6', 'Kids 6-9'],
        datasets: [{
            label: 'Animal Counts',
            data: [{{ $goatCount }}, 0, {{ $maleCount }}, {{ $femaleCount }},
                {{ $goatBreederCount }}, {{ $goatPregnantCount }}, {{ $kidsCount0to3 }},
                {{ $kidsCount3to6 }}, {{ $kidsCount6to9 }}
            ],
            borderColor: 'blue',
            fill: false,
            tension: 0.1,
        }],
    };

    var lineCtx = document.getElementById('animalLineChartCanvas').getContext('2d');
    var lineChart = new Chart(lineCtx, {
        type: 'line',
        data: lineChartData,
    });
</script> --}}
@endsection
