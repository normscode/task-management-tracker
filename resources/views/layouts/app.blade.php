@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TaxTrack')</title>
</head>

<body class="bg-light">

    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        <aside class="bg-dark text-white p-3" style="width: 250px;">

            <div class="mb-4">
                <h4 class="mb-0">TaxTrack</h4>
                <small class="text-secondary">
                    Tax Management System
                </small>
            </div>

            <nav>
                <ul class="nav flex-column gap-1">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active bg-primary text-white rounded' : 'text-white' }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}"
                            class="nav-link {{ request()->routeIs('clients.*') ? 'active bg-primary text-white rounded' : 'text-white' }}">
                            Clients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('engagements.index') }}"
                            class="nav-link {{ request()->routeIs('engagements.*') ? 'active bg-primary text-white rounded' : 'text-white' }}">
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
                    <span class="text-muted">
                        Tax Management Tracker
                    </span>
                </div>

                <div>
                    <span class="fw-semibold">
                        {{ auth()->user()->name }}
                    </span>
                </div>

            </nav>


            {{-- Page Content --}}
            <div class="container-fluid p-4">

                @yield('content')

            </div>

        </main>

    </div>

</body>

</html>