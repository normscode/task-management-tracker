@extends('layouts.app')

@section('title', 'Dashboard - TaxTrack')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Dashboard</h2>

    <p class="text-muted mb-0">
        Welcome back, {{ auth()->user()->name }}.
    </p>
</div>


{{-- Summary Cards --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <p class="text-muted mb-2">
                    Total Clients
                </p>

                <h2 class="fw-bold mb-0">
                    {{ $totalClients }}
                </h2>

                <small class="text-muted">
                    All registered clients
                </small>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <p class="text-muted mb-2">
                    Active Clients
                </p>

                <h2 class="fw-bold mb-0">
                    {{ $activeClients }}
                </h2>

                <small class="text-muted">
                    Currently active
                </small>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <p class="text-muted mb-2">
                    Open Engagements
                </p>

                <h2 class="fw-bold mb-0">
                    {{ $totalOpenEngagements }}
                </h2>

                <small class="text-muted">
                    Requires attention
                </small>

            </div>

        </div>

    </div>

</div>


{{-- Tables --}}
<div class="row g-4">

    {{-- Recent Clients --}}
    <div class="col-lg-7">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-semibold">
                        Recent Clients
                    </h5>

                    <a href="{{ route('clients.index') }}"
                        class="btn btn-sm btn-outline-primary">
                        View All
                    </a>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="px-3">Client</th>
                                <th>Entity Type</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($recentClients as $client)

                            <tr>

                                <td class="px-3">
                                    {{ $client->name }}
                                </td>

                                <td>
                                    {{ $client->entity_type }}
                                </td>

                                <td>

                                    @if ($client->status === 'Active')

                                    <span class="badge text-bg-success">
                                        Active
                                    </span>

                                    @else

                                    <span class="badge text-bg-secondary">
                                        Inactive
                                    </span>

                                    @endif

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- Upcoming Engagements --}}
    <div class="col-lg-5">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-semibold">
                    Upcoming Engagements
                </h5>

            </div>

            <div class="card-body">

                {{-- Engagement items --}}

            </div>

        </div>

    </div>

</div>

@endsection