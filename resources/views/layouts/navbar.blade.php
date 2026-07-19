<nav class="navbar bg-white rounded shadow-sm mb-4">

<div class="container-fluid">

<h4>

Dashboard

</h4>

<div>

@if(auth()->check())

Welcome,

<strong>

{{ auth()->user()->name }}

</strong>

@endif

</div>

</div>

</nav>
