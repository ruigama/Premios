var url_atual = window.location.href;

if(url_atual == 'http://premios.wocc/graficos')
{
    fetch('http://premios.wocc/graficos/cadastrado')
        .then(response => response.json())
        .then(data => 
        {
            data.forEach(item => {
                graficoTabela(item.premio, item.quantidade, item.total_cadastrado);
            });

            let chartData = {
                labels: data.map(item => item.premio),
                datasets: [{
                    label: 'Cadastrados',
                    data: data.map(item => item.total_cadastrado),
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(111, 1, 112)',
                        'rgb(255, 31, 45)',
                        'rgb(44, 68, 185)',
                        'rgb(79, 225, 103)',
                        'rgb(107, 68, 185)',
                        'rgb(236, 239, 38)',
                        'rgb(249, 167, 146)',
                        'rgb(42, 222, 221)',
                        'rgb(255, 99, 132)',
                        'rgb(236, 29, 97)',
                        'rgb(111, 97, 112)'
                    ],
                    hoverOffset: 4
                }]
            };

            let config = {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true
                        }
                    },
                    animation: {
                        onComplete: () => {
                            delayed = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if(context.type === 'data' && context.mode === 'default' && !delayed)
                            {
                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                            }
                            return delay;
                        },
                    },
                },
            };

            let mychart = new Chart(document.getElementById('myChart'), config);
        })
        .catch(error => console.error(error)
    );

    fetch('http://premios.wocc/graficos/coordenador')
        .then(response => response.json())
        .then(data => {

            data.forEach(coord => {
                graficoCoordenador(coord.matricula_coordenador, 
                                   coord.nome_coordenador,
                                   coord.disponivel,
                                   coord.distribuido,
                                   coord.total_recebido
                                   );
            });

            let chartCoordenador = {
                labels: data.map(coord => coord.matricula_coordenador),
                datasets: [{
                    label: 'Cadastrados',
                    data: data.map(coord => coord.total_recebido),
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(107, 68, 185)',
                        'rgb(236, 239, 38)',
                        'rgb(249, 167, 146)',
                        'rgb(42, 222, 221)',
                        'rgb(255, 99, 132)',
                        'rgb(236, 29, 97)',
                        'rgb(255, 205, 86)'
                    ],
                }]
            };

            let dados_chart = {
                type: 'bar',
                data: chartCoordenador,
                options: {
                    responsive: false,
                    indexAxis: 'x',
                    elements: {
                        bar: {
                            borderWidth: 2,
                        }
                    },
                }
            }

            let coordenadorChart = new Chart(document.getElementById('chartCoordenador'), dados_chart);
        })
        .catch(error => console.error(error)
    );

    fetch('http://premios.wocc/graficos/supervisor')
        .then(response => response.json())
        .then(data => {

            data.forEach(supervisor => {
                graficoSupervisor(supervisor.matricula_supervisor, 
                                  supervisor.nome_supervisor,
                                  supervisor.premio,
                                  supervisor.disponivel,
                                  supervisor.distribuido
                                 );
            });

            let chartSupervisor = {
                labels: data.map(supervisor => supervisor.matricula_supervisor),
                datasets: [
                    {
                    label: 'Cadastrados 1',
                    data: data.map(supervisor => supervisor.disponivel),
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(107, 68, 185)',
                        'rgb(236, 239, 38)',
                        'rgb(249, 167, 146)',
                        'rgb(42, 222, 221)',
                        'rgb(255, 99, 132)',
                        'rgb(236, 29, 97)',
                        'rgb(255, 205, 86)'
                    ],
                    label: 'Cadastrados 2',
                    data: data.map(supervisor => supervisor.distribuido),
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(107, 68, 185)',
                        'rgb(236, 239, 38)',
                        'rgb(249, 167, 146)',
                        'rgb(42, 222, 221)',
                        'rgb(255, 99, 132)',
                        'rgb(236, 29, 97)',
                        'rgb(255, 205, 86)'
                    ],
                    }
                ]
            };

            const dadosSuper = {
                type: 'line',
                data: chartSupervisor,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Line Chart'
                        }
                    }
                },
            };

            let supervisorChart = new Chart(document.getElementById('chartSupervisor'), dadosSuper);
        })
        .catch(error => console.error(error)
    );


    function graficoTabela(premio, quantidade, total_cadastrado)
    {
        let pTable = document.getElementById('tabelaGrafico');
        let tRow = document.createElement('tr');
        tRow.innerHTML = `
            <td>${premio}</td>
            <td class='text-center'>${quantidade}</td>
            <td class='text-center'>${total_cadastrado}</td>
        `;
        pTable.appendChild(tRow);
    }

    function graficoCoordenador(matricula_coordenador, nome_coordenador, disponivel,distribuido, total_recebido)
    {
        let cTable = document.getElementById('coordenadorGrafico');
        let cRow = document.createElement('tr');
        cRow.innerHTML = `
            <td>${matricula_coordenador}</td>
            <td>${nome_coordenador}</td>
            <td class='text-center'>${disponivel}</td>
            <td class='text-center'>${distribuido}</td>
            <td class='text-center'>${total_recebido}</td>
        `;
        cTable.appendChild(cRow);
    }

    function graficoSupervisor(matricula_supervisor, nome_supervisor, premio, disponivel, distribuido)
    {
        let sTable = document.getElementById('supervisorGrafico');
        let sRow = document.createElement('tr');
        sRow.innerHTML = `
            <td>${matricula_supervisor}</td>
            <td>${nome_supervisor}</td>
            <td>${premio}</td>
            <td class='text-center'>${disponivel}</td>
            <td class='text-center'>${distribuido}</td>
        `;
        sTable.appendChild(sRow);
    }

}