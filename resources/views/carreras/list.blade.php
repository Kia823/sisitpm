@extends('layouts.app')

@section('content')
<section class="hero-card">
    <div>
        <div style="display:inline-block;padding:6px 10px;border-radius:999px;background:rgba(255,255,255,0.18);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Carreras</div>
        <h1 style="margin:10px 0 8px;font-size:28px;">Carreras</h1>
        <p>Listado de carreras disponibles.</p>
    </div>
    <div class="stat-grid">
        <div><strong>{{ $carreras->count() }}</strong><span>Carreras</span></div>
    </div>
</section>

<section class="panel">
    <h2>Listado</h2>
    @if(session('status'))
        <div class="result-box">
            <h3>Éxito</h3>
            <p>{{ session('status') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="result-box" style="border-color:#fecaca;background:#fff1f2;">
            <h3>Error</h3>
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="link-list">
        @foreach($carreras as $c)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px;border:1px solid #eef; border-radius:8px; margin-bottom:8px;background:#fff;">
                <div>
                    <a href="{{ route('carreras.show', \Illuminate\Support\Str::slug($c->nombre)) }}">{{ $c->nombre }}</a>
                </div>
                <div style="display:flex;gap:8px;">
                    <a class="btn" href="{{ route('carreras.show', \Illuminate\Support\Str::slug($c->nombre)) }}">Ver</a>
                    <a class="btn" href="{{ route('carreras.show', \Illuminate\Support\Str::slug($c->nombre)) }}?nuevo_ambiente=1">+ Nuevo ambiente</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
