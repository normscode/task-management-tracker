@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TaxTrack</title>
</head>

<body class="bg-light">

    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        <aside class="bg-dark text-white p-3" style="width: 250px;">

            <div class="mb-4">
                <h4 class="mb-0">TaxTrack</h4>
                <small class="text-secondary">Tax Management System</small>
            </div>

            <nav>
                <ul class="nav flex-column gap-1">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link active bg-primary text-white rounded">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/clients') }}" class="nav-link text-white">
                            Clients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-white">
                            Tax Engagements
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="mt-auto pt-4">

                <hr class="border-secondary">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-outline-light w-100">
                        Logout
                    </button>
                </form>

            </div>

        </aside>


        {{-- Main Content --}}
        <main class="flex-grow-1">

            {{-- Top Navigation --}}
            <nav class="navbar bg-white border-bottom px-4 py-3">

                <div>
                    <span class="text-muted">Tax Management Tracker</span>
                </div>

                <div>
                    <span class="fw-semibold">
                        {{ auth()->user()->name }}
                    </span>
                </div>

            </nav>


            {{-- Dashboard Content --}}
            <div class="container-fluid p-4">

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

                                <h2 class="fw-bold mb-0">{{ $totalClients }}</h2>

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

                                <h2 class="fw-bold mb-0">{{ $activeClients }}</h2>

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

                                    <a href="{{ url('/clients') }}"
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

                                <div class="d-flex justify-content-between align-items-start mb-3">

                                    <div>
                                        <h6 class="mb-1">
                                            Tax Return
                                        </h6>

                                        <small class="text-muted">
                                            Maria Santos Consulting LLC
                                        </small>
                                    </div>

                                    <span class="badge text-bg-warning">
                                        Pending
                                    </span>

                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-start mb-3">

                                    <div>
                                        <h6 class="mb-1">
                                            Tax Preparation
                                        </h6>

                                        <small class="text-muted">
                                            Juan Dela Cruz Corporation
                                        </small>
                                    </div>

                                    <span class="badge text-bg-primary">
                                        In Progress
                                    </span>

                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-start">

                                    <div>
                                        <h6 class="mb-1">
                                            Tax Advisory
                                        </h6>

                                        <small class="text-muted">
                                            ABC Consulting
                                        </small>
                                    </div>

                                    <span class="badge text-bg-warning">
                                        Pending
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>

</html>