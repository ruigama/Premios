@extends('layouts.painel')
@section('title', 'Graficos')
@section('content')
    <div class="col-md-10 col-sm-12 offset-md-1">
        <div class="row">
            <div id="info-container" class="col-md-12 col-sm-12">
                <h3>Premios totais</h3>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th>Premio</th>
                            <th class="text-center">Quantidade disponivel</th>
                            <th class="text-center">Total cadastrada</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaGrafico"></tbody>
                </table>
            </div>
            {{-- <div class="col-md-6 col-sm-12">
                <canvas height="340px" class="stats-small stats-small--1 card card-small mt-3" width="340px" id="myChart"></canvas>
            </div> --}}
            <div id="info-container" class="col-md-12 col-sm-12">
                <h3>Coordenadores</h3>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th>Matrícula</th>
                            <th>Coordenador</th>
                            <th class="text-center">Disponivel</th>
                            <th class="text-center">Distribuida</th>
                            <th class="text-center">Total Recebido</th>
                        </tr>
                    </thead>
                    <tbody id="coordenadorGrafico"></tbody>
                </table>
            </div>
            {{-- <div class="col-md-6 col-sm-12">
                <canvas height="340px" class="stats-small stats-small--1 card card-small my-3" width="340px" id="chartCoordenador"></canvas>
            </div> --}}
            <div id="info-container" class="col-md-12 col-sm-12">
                <h3>Supervisores</h3>
                <table class="mb-5 table table-striped table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th>Matrícula</th>
                            <th>Supervisor</th>
                            <th >Premio</th>
                            <th class="text-center">Disponivel</th>
                            <th class="text-center">Distribuido</th>
                        </tr>
                    </thead>
                    <tbody id="supervisorGrafico"></tbody>
                </table>
            </div>
            {{-- <div class="col-md-6 col-sm-12">
                <canvas height="340px" class="stats-small stats-small--1 card card-small my-3" width="340px" id="chartSupervisor"></canvas>
            </div> --}}

        </div>
        
    </div>
@endsection
