{{-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin --}}

@props([
    'user' => Auth::user(),
])

<div>
    <div class="lg:col-start-3 lg:col-span-1">
        <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
            <h2 class="text-lg font-medium text-gray-900">My driver level</h2>
            <div class="pt-6 relative flex items-center h-full justify-center">
                <div class="flex items-center h-full justify-center relative">
                    <canvas tabindex="0" class="focus:outline-none" aria-label="chart" role="img"
                            id="driver-level-progress" data-percent="{{ $user->percentageUntilLevelUp() }}" width="200"
                            height="200"></canvas>
                    <div class="w-40 h-40 absolute rounded-full flex items-center justify-center">
                        <p tabindex="0"
                           class="focus:outline-none text-4xl font-medium leading-10 text-center text-orange-600">
                            {{ $user->driver_level }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex pt-6 justify-center text-center flex-col">
                <p class="focus:outline-none text-sm leading-none text-gray-800">
                    {{ number_format($user->totalDriverPoints()) }}
                    / {{ number_format($user->nextDriverLevelPoints()) }} XP
                    @if($user->percentageUntilLevelUp() === 100)
                        <br>
                        <span
                            class="mt-3 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-yellow-100 text-yellow-800">
                            Congrats! We are processing your level up.
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <script>
        const percentValue = {{ $user->percentageUntilLevelUp() }};

        Chart.pluginService.register({
            afterUpdate: function (chart) {
                if (chart.config.options.elements.arc.roundedCornersFor !== undefined) {
                    const arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundedCornersFor];
                    arc.round = {
                        x: (chart.chartArea.left + chart.chartArea.right) / 2,
                        y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                        radius: (chart.outerRadius + chart.innerRadius) / 2,
                        thickness: (chart.outerRadius - chart.innerRadius) / 2 - 1,
                        backgroundColor: arc._model.backgroundColor,
                    };
                }
            },

            afterDraw: function (chart) {
                if (chart.config.options.elements.arc.roundedCornersFor !== undefined) {
                    const ctx = chart.chart.ctx;
                    const arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundedCornersFor];
                    const startAngle = Math.PI / 2 - arc._view.startAngle;
                    const endAngle = Math.PI / 2 - arc._view.endAngle;

                    ctx.save();
                    ctx.translate(arc.round.x, arc.round.y);
                    ctx.fillStyle = arc.round.backgroundColor;
                    ctx.beginPath();
                    ctx.arc(arc.round.radius * Math.sin(startAngle), arc.round.radius * Math.cos(startAngle), arc.round.thickness, 0, 2 * Math.PI);
                    ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round.radius * Math.cos(endAngle), arc.round.thickness, 0, 2 * Math.PI);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                }
            },
        });
        const config = {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        data: [percentValue, 100 - percentValue], // Set the value shown in the chart as a percentage (out of 100)
                        backgroundColor: ["#ff5a1f", "#fde4ce"],
                        borderWidth: 2,
                    },
                ],
            },
            options: {
                hover: {mode: null},
                elements: {
                    arc: {
                        roundedCornersFor: 0,
                    },
                },
                cutoutPercentage: 80,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: false,
                },
                legend: {
                    display: false,
                },
            },
        };
        const ctx = document.getElementById("driver-level-progress").getContext("2d");
        const driverLevelProgressChart = new Chart(ctx, config);
    </script>
</div>
