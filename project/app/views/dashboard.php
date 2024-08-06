<?php include '../app/views/header.php'; ?>

<div class="card">

<?php if (isset($_SESSION['user'])): ?>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>

        <div id="chart" style="height: 350px;"></div>
        
        <script>
            var months = <?php echo json_encode($usersPerMonth['months']); ?>;
            var counts = <?php echo json_encode($usersPerMonth['counts']); ?>;
        </script>
    <?php else: ?>
        <p>Você precisa estar logado para ver esta página.</p>
    <?php endif; ?>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    var options = {
        series: [{
            data: counts 
        }],
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                columnWidth: '45%',
                distributed: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + ' usuários'; 
                }
            },
            theme: 'dark', 
            style: {
                fontSize: '12px',
                color: 'black' 
            }
        },
        xaxis: {
            categories: months, 
            labels: {
                style: {
                    fontSize: '12px',
                    colors: 'white'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '12px',
                    colors: 'white' 
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
});

</script>