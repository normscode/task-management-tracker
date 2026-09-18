@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clients - TaxTrack</title>
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
                            class="nav-link text-white">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}"
                            class="nav-link active bg-primary text-white rounded">
                            Clients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#"
                            class="nav-link text-white">
                            Tax Engagements
                        </a>
                    </li>

                </ul>

            </nav>

            <div class="mt-auto pt-4">

                <hr class="border-secondary">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="btn btn-outline-light w-100">
                        Logout
                    </button>
                </form>

            </div>

        </aside>


        {{-- Main Content --}}
        <main class="flex-grow-1">

            {{-- Topbar --}}
            <nav class="navbar bg-white border-bottom px-4 py-3">

                <span class="text-muted">
                    Client Management
                </span>

                <span class="fw-semibold">
                    {{ auth()->user()->name }}
                </span>

            </nav>


            {{-- Page Content --}}
            <div class="container-fluid p-4">

                {{-- Page Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2 class="fw-bold mb-1">
                            Clients
                        </h2>

                        <p class="text-muted mb-0">
                            Manage your tax clients and their information.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addClientModal">
                        + Add Client
                    </button>

                </div>


                {{-- Search / Filter --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-8">

                                <label for="search"
                                    class="form-label">
                                    Search
                                </label>

                                <input
                                    type="text"
                                    id="search"
                                    class="form-control"
                                    placeholder="Search by name, email, or phone...">

                            </div>


                            <div class="col-md-4">

                                <label for="status"
                                    class="form-label">
                                    Status
                                </label>

                                <select id="status"
                                    class="form-select">

                                    <option value="">
                                        All Statuses
                                    </option>

                                    <option value="Active">
                                        Active
                                    </option>

                                    <option value="Inactive">
                                        Inactive
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Client Table --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-semibold">
                            Client List
                        </h5>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4">
                                            Client
                                        </th>

                                        <th>
                                            Email
                                        </th>

                                        <th>
                                            Phone
                                        </th>

                                        <th>
                                            Entity Type
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($clients as $client)

                                    <tr data-client-id="{{ $client->id }}">

                                        <td class="px-4">
                                            <div class="fw-semibold client-name">
                                                {{ $client->name }}
                                            </div>
                                        </td>

                                        <td class="client-email">
                                            {{ $client->email ?? '—' }}
                                        </td>

                                        <td class="client-phone">
                                            {{ $client->phone ?? '—' }}
                                        </td>

                                        <td class="client-entity-type">
                                            {{ $client->entity_type }}
                                        </td>

                                        <td>
                                            @if ($client->status === 'Active')
                                            <span class="badge text-bg-success client-status">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge text-bg-secondary client-status">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary edit-client"
                                                data-id="{{ $client->id }}">
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-danger archive-client"
                                                data-id="{{ $client->id }}">
                                                Archive
                                            </button>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="6"
                                            class="text-center py-5 text-muted">

                                            No clients found.

                                        </td>

                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>



    {{-- Add Client Modal --}}
    <div
        class="modal fade"
        id="addClientModal"
        tabindex="-1"
        aria-labelledby="addClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title fw-semibold" id="addClientModalLabel">
                            Add Client
                        </h5>

                        <small class="text-muted">
                            Enter the client's information below.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <form
                    id="addClientForm"
                    method="POST"
                    action="{{ url('/clients') }}">

                    @csrf


                    <div class="modal-body">

                        <div id="formErrors" class="alert alert-danger d-none"></div>

                        <div class="row g-3">

                            {{-- Client Name --}}
                            <div class="col-12">

                                <label for="name" class="form-label">
                                    Client Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Maria Santos Consulting LLC"
                                    required>

                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">

                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="client@example.com">

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">

                                <label for="phone" class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="09171234567">

                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Entity Type --}}
                            <div class="col-md-6">

                                <label for="entity_type" class="form-label">
                                    Entity Type
                                </label>

                                <select
                                    name="entity_type"
                                    id="entity_type"
                                    class="form-select @error('entity_type') is-invalid @enderror"
                                    required>
                                    <option value="">Select entity type</option>

                                    <option value="Individual"
                                        @selected(old('entity_type')==='Individual' )>
                                        Individual
                                    </option>

                                    <option value="LLC"
                                        @selected(old('entity_type')==='LLC' )>
                                        LLC
                                    </option>

                                    <option value="Corporation"
                                        @selected(old('entity_type')==='Corporation' )>
                                        Corporation
                                    </option>

                                    <option value="Partnership"
                                        @selected(old('entity_type')==='Partnership' )>
                                        Partnership
                                    </option>

                                    <option value="Nonprofit"
                                        @selected(old('entity_type')==='Nonprofit' )>
                                        Nonprofit
                                    </option>

                                </select>

                                @error('entity_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">

                                <label for="status" class="form-label">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="">Select status</option>

                                    <option value="Active"
                                        @selected(old('status', 'Active' )==='Active' )>
                                        Active
                                    </option>

                                    <option value="Inactive"
                                        @selected(old('status')==='Inactive' )>
                                        Inactive
                                    </option>

                                </select>

                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Create Client
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>


    {{-- Edit Client Modal --}}
    <div
        class="modal fade"
        id="editClientModal"
        tabindex="-1"
        aria-labelledby="editClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title fw-semibold" id="editClientModalLabel">
                            Edit Client
                        </h5>

                        <small class="text-muted">
                            Update the client's information below.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <form id="editClientForm">

                    @csrf

                    <div class="modal-body">

                        <div id="editFormErrors" class="alert alert-danger d-none"></div>

                        <input type="hidden" id="editClientId">

                        <div class="row g-3">

                            <div class="col-12">

                                <label for="editName" class="form-label">
                                    Client Name
                                </label>

                                <input
                                    type="text"
                                    id="editName"
                                    name="name"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="col-md-6">

                                <label for="editEmail" class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="editEmail"
                                    name="email"
                                    class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label for="editPhone" class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    id="editPhone"
                                    name="phone"
                                    class="form-control">

                            </div>

                            <div class="col-md-6">

                                <label for="editEntityType" class="form-label">
                                    Entity Type
                                </label>

                                <select
                                    id="editEntityType"
                                    name="entity_type"
                                    class="form-select"
                                    required>
                                    <option value="Individual">Individual</option>
                                    <option value="LLC">LLC</option>
                                    <option value="Corporation">Corporation</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Nonprofit">Nonprofit</option>
                                </select>

                            </div>

                            <div class="col-md-6">

                                <label for="editStatus" class="form-label">
                                    Status
                                </label>

                                <select
                                    id="editStatus"
                                    name="status"
                                    class="form-select"
                                    required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</body>

</html>