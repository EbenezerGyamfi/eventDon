const chartLabels = Object.keys(stats);
const chartValues = Object.values(stats);
// console.log({ chartLabels, chartValues });

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: chartLabels,
        datasets: [{
            // label: '# of Votes',
            data: chartValues,
            backgroundColor: [
                'rgba(37, 190, 53, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(208, 27, 6, 0.2)'
            ],
            borderColor: [
                'rgba(37, 190, 53, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(208, 27, 6, 1)'
            ],
            borderWidth: 1
        }]
    },
    // https://stackoverflow.com/questions/37621020/setting-width-and-height
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});