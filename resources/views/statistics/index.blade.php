@extends('layouts.admin')

@section('title', 'Estadísticas del Sistema')

@section('content')
    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;">
        <div>
            <div style="font-size:11px; font-weight:800; color:var(--oro); letter-spacing:1px; text-transform:uppercase; margin-bottom:6px;">ANÁLISIS</div>
            <h1 style="font-family:'Sora',sans-serif; font-size:32px; font-weight:700; color:var(--text-dark); margin-bottom:8px;">Estadísticas del Sistema</h1>
            <p style="color:var(--text-muted);">Métricas de respuestas, participación y tendencias</p>
        </div>
        <div>
            <button class="btn-neu" style="padding:10px 20px; font-weight:700; display:flex; align-items:center; gap:8px; color:var(--text-dark);">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Exportar
            </button>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="neu-card" style="padding:16px 24px; margin-bottom:30px; display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
        <form action="{{ route('statistics.index') }}" method="GET" style="display:contents;">
            
            {{-- Survey Select --}}
            <div style="display:flex; align-items:center; gap:12px; flex:1; min-width:280px;">
                <label style="font-weight:700; color:var(--text-muted); font-size:13px;">Encuesta:</label>
                <div style="position:relative; flex:1;">
                    <select name="survey_id" onchange="this.form.submit()" 
                        style="width:100%; appearance:none; background:var(--bg); border:none; padding:10px 16px; border-radius:12px; font-size:13px; font-weight:600; color:var(--text-dark); box-shadow:var(--neu-in-sm); cursor:pointer; outline:none;">
                        @foreach($surveys as $survey)
                            <option value="{{ $survey->id }}" {{ $selectedSurvey && $selectedSurvey->id == $survey->id ? 'selected' : '' }}>
                                {{ $survey->title }} ({{ \Carbon\Carbon::parse($survey->start_date)->year }})
                            </option>
                        @endforeach
                    </select>
                    <div style="position:absolute; right:14px; top:50%; transform:translateY(-50%); pointer-events:none; color:var(--text-muted);">▼</div>
                </div>
            </div>

            {{-- Date Range --}}
            <div style="display:flex; align-items:center; gap:12px;">
                <label style="font-weight:700; color:var(--text-muted); font-size:13px;">Desde:</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                    style="background:var(--bg); border:none; padding:8px 12px; border-radius:10px; font-size:12px; color:var(--text-dark); box-shadow:var(--neu-in-sm); outline:none;">
                
                <label style="font-weight:700; color:var(--text-muted); font-size:13px;">Hasta:</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                    style="background:var(--bg); border:none; padding:8px 12px; border-radius:10px; font-size:12px; color:var(--text-dark); box-shadow:var(--neu-in-sm); outline:none;">
            </div>

            <button type="submit" style="background:var(--uaemex); color:white; border:none; padding:10px 24px; border-radius:12px; font-weight:700; font-size:13px; cursor:pointer; box-shadow:4px 4px 10px rgba(45,80,22,0.3); display:flex; align-items:center; gap:6px;">
                ▼ Aplicar
            </button>
        </form>
    </div>

    {{-- KPI CARDS --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:30px; margin-bottom:30px;">
        
        {{-- Total Responses --}}
        <div class="neu-card" style="padding:30px; display:flex; align-items:center; gap:24px;">
            <div style="position:relative; width:80px; height:80px; display:flex; align-items:center; justify-content:center;">
                <!-- Circular Progress Background -->
                <svg width="80" height="80" viewBox="0 0 100 100" style="transform: rotate(-90deg);">
                    <circle cx="50" cy="50" r="40" stroke="var(--bg-dark)" stroke-width="12" fill="none" />
                    <circle cx="50" cy="50" r="40" stroke="var(--uaemex)" stroke-width="12" fill="none" 
                        stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * 100 / 100) }}" stroke-linecap="round" />
                </svg>
                <div style="position:absolute; text-align:center;">
                    <div style="font-weight:800; font-size:18px; color:var(--text-dark); line-height:1;">{{ $stats['total_responses'] }}</div>
                    <div style="font-size:8px; font-weight:700; color:var(--text-muted);">RESP.</div>
                </div>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:700; color:var(--text-dark); margin-bottom:4px;">Total de Respuestas</h3>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">Periodo seleccionado</div>
                <div style="display:inline-flex; align-items:center; gap:4px; background:var(--verde-pale); padding:4px 10px; border-radius:20px; font-size:11px; font-weight:800; color:var(--uaemex);">
                    <span>↑</span> {{ abs($stats['responses_growth']) }}% vs año anterior
                </div>
            </div>
        </div>

        {{-- Completion Rate --}}
        <div class="neu-card" style="padding:30px; display:flex; align-items:center; gap:24px;">
            <div style="position:relative; width:80px; height:80px; display:flex; align-items:center; justify-content:center;">
                <!-- Circular Progress Background -->
                <svg width="80" height="80" viewBox="0 0 100 100" style="transform: rotate(-90deg);">
                    <circle cx="50" cy="50" r="40" stroke="var(--bg-dark)" stroke-width="12" fill="none" />
                    <circle cx="50" cy="50" r="40" stroke="var(--uaemex)" stroke-width="12" fill="none" 
                        stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * $stats['completion_rate'] / 100) }}" stroke-linecap="round" />
                </svg>
                <div style="position:absolute; text-align:center;">
                    <div style="font-weight:800; font-size:18px; color:var(--text-dark); line-height:1;">{{ $stats['completion_rate'] }}%</div>
                    <div style="font-size:8px; font-weight:700; color:var(--text-muted);">COMP.</div>
                </div>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:700; color:var(--text-dark); margin-bottom:4px;">Tasa de Completado</h3>
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">Encuestas finalizadas</div>
                <div style="display:inline-flex; align-items:center; gap:4px; background:var(--bg-dark); padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; color:var(--text-muted);">
                    - Sin variación
                </div>
            </div>
        </div>

    </div>

    {{-- BOTTOM GRID --}}
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:30px;">
        
        {{-- Chart Section --}}
        <div class="neu-card" style="padding:24px; min-height:300px;">
            <h3 style="font-size:16px; font-weight:700; color:var(--text-dark); margin-bottom:20px;">Distribución de Respuestas por Día</h3>
            <div style="position:relative; height:220px; width:100%;">
                <canvas id="responsesChart"></canvas>
            </div>
        </div>

        {{-- Top Surveys --}}
        <div>
            <h3 style="font-size:16px; font-weight:700; color:var(--text-dark); margin-bottom:20px;">Top Encuestas</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                @foreach($topSurveys as $index => $survey)
                    <div class="neu-card" style="padding:16px; display:flex; align-items:center; gap:16px; margin-bottom:0;">
                        <div style="font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:var(--oro);">
                            {{ $loop->iteration }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:700; font-size:13px; color:var(--text-dark); margin-bottom:2px;">{{ $survey->title }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $survey->responses_count }} respuestas</div>
                        </div>
                        <div style="font-weight:700; font-size:14px; color:var(--text-dark);">
                            {{ $survey->responses_count }}
                        </div>
                    </div>
                @endforeach
                @if($topSurveys->isEmpty())
                    <div style="text-align:center; padding:20px; color:var(--text-muted); font-style:italic; font-size:12px;">
                        No hay datos disponibles
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('responsesChart').getContext('2d');
            
            // Generate some random bubble/scatter data if empty, or use real data
            const labels = @json($stats['responses_per_day']['labels']);
            const data = @json($stats['responses_per_day']['data']);

            // If data is empty (no responses), show dummy visualization for UI demo purposes? 
            // Better to show real empty chart.
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Respuestas',
                        data: data,
                        backgroundColor: '#2D5016',
                        borderColor: '#2D5016',
                        borderWidth: 0,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: function(context) {
                            // Alternating colors for bubbles style in the image
                            const colors = ['#2D5016', '#C99A0A', '#3a6b1c', '#f5e6a3'];
                            return colors[context.dataIndex % colors.length];
                        },
                        showLine: false // Scatter style as in image
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#2D5016',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            display: false, // Hide Y axis as in image
                            beginAtZero: true
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { display: false } // Hide X axis labels for cleaner look or keep them? Image shows no axis.
                        }
                    },
                    layout: {
                        padding: 20
                    }
                }
            });
        });
    </script>

    <style>
        .btn-neu {
            background: var(--bg);
            border: none;
            border-radius: 12px;
            box-shadow: var(--neu-out);
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-neu:active {
            box-shadow: var(--neu-press);
            transform: translateY(1px);
        }
    </style>
@endsection
