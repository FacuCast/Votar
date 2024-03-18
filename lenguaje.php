<?php
$palabras = array();
$total_palabras = 0;

foreach ($obtenido as $fila) {
    $texto = $fila['lenguaje'];
    $palabras_fila = str_word_count($texto, 1); // Obtener un array con las palabras de la fila
    $total_palabras += count($palabras_fila); // Actualizar el total de palabras

    foreach ($palabras_fila as $palabra) {
        if (isset($palabras[$palabra])) {
            $palabras[$palabra]++;
        } else {
            $palabras[$palabra] = 1;
        }
    }
}

// Calcular el porcentaje de palabras repetidas
$porcentajes = array();
foreach ($palabras as $palabra => $repeticiones) {
    $porcentaje = ($repeticiones / $total_palabras) * 100;
    $porcentajes[$palabra] = array(
        'Votos' => $repeticiones,
        'porcentaje' => $porcentaje
    );
}

// Ordenar el array de porcentajes de mayor a menor
arsort($porcentajes);

// Obtener las 10 palabras con mayor porcentaje de Lenguaje
$top_palabras = array_slice($porcentajes, 0, 10, true);

// Preparar los datos para la gráfica
$labels = array_keys($top_palabras);
$valores = array_column($top_palabras, 'porcentaje');
$repeticiones = array_column($top_palabras, 'Votos');

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="grafico4"></canvas>

<script>
    var ctx = document.getElementById('grafico4').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: '% de Lenguaje',
                data: <?php echo json_encode($valores); ?>,
                backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(128, 0, 0, 0.2)',
                        'rgba(0, 128, 0, 0.2)',
                        'rgba(0, 0, 128, 0.2)',
                        'rgba(128, 128, 0, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(128, 0, 0, 1)',
                        'rgba(0, 128, 0, 1)',
                        'rgba(0, 0, 128, 1)',
                        'rgba(128, 128, 0, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '% de Lenguaje'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Palabra'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y.toFixed(3) + '%';
                            label += ' (' + <?php echo json_encode($repeticiones); ?>[context.dataIndex] + ' Votos)';
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
