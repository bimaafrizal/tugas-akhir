@extends('layouts.dashboard.main')
@section('title')
Vertical Column Layout
@endsection

@section('content')
<nav class="navbar navbar-light">
    <div class="container d-block">
        <a href="index.html"><i class="bi bi-chevron-left"></i></a>
        <a class="navbar-brand ms-4" href="index.html">
            <img src="assets/images/logo/logo.svg">
        </a>
    </div>
</nav>


<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h4 class="card-title">Single Layout</h4>
        </div>
        <div class="card-body">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus nemo quasi labore expedita?
                Veritatis
                at maxime id voluptates excepturi molestiae possimus blanditiis dicta consequuntur maiores suscipit,
                eveniet neque obcaecati doloribus.</p>
        </div>
    </div>
</div>
@endsection