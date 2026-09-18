@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tax Engagements - TaxTrack</title>
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

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a
                            href="{{ route('dashboard') }}"
                            class="nav-link text-white">
                            Dashboard
                        </a>
                    </li>

                    {{-- Clients --}}
                    <li class="nav-item">
                        <a
                            href="{{ route('clients.index') }}"
                            class="nav-link text-white">
                            Clients
                        </a>
                    </li>

                    {{-- Tax Engagements --}}
                    <li class="nav-item">
                        <a
                            href="{{ route('engagements.index') }}"
                            class="nav-link active bg-primary text-white rounded">
                            Tax Engagements
                        </a>
                    </li>

                </ul>

            </nav>

            <div class="mt-auto pt-4">

                <hr class="border-secondary">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
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
                    Tax Engagement Management
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
                            Tax Engagements
                        </h2>

                        <p class="text-muted mb-0">
                            Manage client tax and accounting engagements.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addEngagementModal">
                        + Add Engagement
                    </button>

                </div>


                {{-- Search / Filter --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="row g-3">

                            {{-- Search --}}
                            <div class="col-md-8">

                                <label
                                    for="engagementSearch"
                                    class="form-label">
                                    Search
                                </label>

                                <input
                                    type="text"
                                    id="engagementSearch"
                                    class="form-control"
                                    placeholder="Search by client, service type, or tax year...">

                            </div>


                            {{-- Status --}}
                            <div class="col-md-4">

                                <label
                                    for="engagementStatusFilter"
                                    class="form-label">
                                    Status
                                </label>

                                <select
                                    id="engagementStatusFilter"
                                    class="form-select">

                                    <option value="">
                                        All Statuses
                                    </option>

                                    <option value="Open">
                                        Open
                                    </option>

                                    <option value="In Progress">
                                        In Progress
                                    </option>

                                    <option value="Completed">
                                        Completed
                                    </option>

                                    <option value="Cancelled">
                                        Cancelled
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Engagement Table --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-semibold">
                            Engagement List
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
                                            Service Type
                                        </th>

                                        <th>
                                            Tax Year
                                        </th>

                                        <th>
                                            Start Date
                                        </th>

                                        <th>
                                            Due Date
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="engagementTableBody">

                                    @forelse ($engagements as $engagement)

                                    <tr data-engagement-id="{{ $engagement->id }}">

                                        {{-- Client --}}
                                        <td class="px-4">

                                            <div class="fw-semibold engagement-client">
                                                {{ $engagement->client->name }}
                                            </div>

                                        </td>


                                        {{-- Service Type --}}
                                        <td class="engagement-service-type">
                                            {{ $engagement->service_type }}
                                        </td>


                                        {{-- Tax Year --}}
                                        <td class="engagement-tax-year">
                                            {{ $engagement->tax_year }}
                                        </td>


                                        {{-- Start Date --}}
                                        <td class="engagement-start-date">
                                            {{ \Carbon\Carbon::parse($engagement->start_date)->format('M d, Y') }}
                                        </td>


                                        {{-- Due Date --}}
                                        <td class="engagement-due-date">
                                            {{ \Carbon\Carbon::parse($engagement->due_date)->format('M d, Y') }}
                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            @if ($engagement->status === 'Open')

                                            <span class="badge text-bg-primary engagement-status">
                                                Open
                                            </span>

                                            @elseif ($engagement->status === 'In Progress')

                                            <span class="badge text-bg-warning engagement-status">
                                                In Progress
                                            </span>

                                            @elseif ($engagement->status === 'Completed')

                                            <span class="badge text-bg-success engagement-status">
                                                Completed
                                            </span>

                                            @else

                                            <span class="badge text-bg-secondary engagement-status">
                                                Cancelled
                                            </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary edit-engagement"
                                                data-id="{{ $engagement->id }}">
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-danger delete-engagement"
                                                data-id="{{ $engagement->id }}">
                                                Delete
                                            </button>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr id="noEngagementsRow">

                                        <td
                                            colspan="7"
                                            class="text-center py-5 text-muted">
                                            No engagements found.
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


    {{-- Add Engagement Modal --}}
    <div
        class="modal fade"
        id="addEngagementModal"
        tabindex="-1"
        aria-labelledby="addEngagementModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <div>

                        <h5
                            class="modal-title fw-semibold"
                            id="addEngagementModalLabel">
                            Add Engagement
                        </h5>

                        <small class="text-muted">
                            Enter the engagement information below.
                        </small>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>


                <form
                    id="addEngagementForm"
                    method="POST"
                    action="{{ url('/engagements') }}">

                    @csrf

                    <div class="modal-body">

                        {{-- AJAX Validation Errors --}}
                        <div
                            id="engagementFormErrors"
                            class="alert alert-danger d-none"></div>


                        <div class="row g-3">

                            {{-- Client --}}
                            <div class="col-12">

                                <label
                                    for="engagementClient"
                                    class="form-label">
                                    Client
                                </label>

                                <select
                                    name="client_id"
                                    id="engagementClient"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Select client
                                    </option>

                                    @foreach ($clients as $client)

                                    <option value="{{ $client->id }}">
                                        {{ $client->name }}
                                    </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Service Type --}}
                            <div class="col-md-6">

                                <label
                                    for="engagementServiceType"
                                    class="form-label">
                                    Service Type
                                </label>

                                <select
                                    name="service_type"
                                    id="engagementServiceType"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Select service type
                                    </option>

                                    <option value="Tax Preparation">
                                        Tax Preparation
                                    </option>

                                    <option value="Bookkeeping">
                                        Bookkeeping
                                    </option>

                                    <option value="Tax Consultation">
                                        Tax Consultation
                                    </option>

                                    <option value="Payroll">
                                        Payroll
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>

                                </select>

                            </div>


                            {{-- Tax Year --}}
                            <div class="col-md-6">

                                <label
                                    for="engagementTaxYear"
                                    class="form-label">
                                    Tax Year
                                </label>

                                <input
                                    type="number"
                                    name="tax_year"
                                    id="engagementTaxYear"
                                    class="form-control"
                                    min="2000"
                                    max="2100"
                                    value="{{ date('Y') }}"
                                    required>

                            </div>


                            {{-- Start Date --}}
                            <div class="col-md-6">

                                <label
                                    for="engagementStartDate"
                                    class="form-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    id="engagementStartDate"
                                    class="form-control"
                                    required>

                            </div>


                            {{-- Due Date --}}
                            <div class="col-md-6">

                                <label
                                    for="engagementDueDate"
                                    class="form-label">
                                    Due Date
                                </label>

                                <input
                                    type="date"
                                    name="due_date"
                                    id="engagementDueDate"
                                    class="form-control"
                                    required>

                            </div>


                            {{-- Status --}}
                            <div class="col-md-6">

                                <label
                                    for="engagementStatus"
                                    class="form-label">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    id="engagementStatus"
                                    class="form-select"
                                    required>

                                    <option value="Open">
                                        Open
                                    </option>

                                    <option value="In Progress">
                                        In Progress
                                    </option>

                                    <option value="Completed">
                                        Completed
                                    </option>

                                    <option value="Cancelled">
                                        Cancelled
                                    </option>

                                </select>

                            </div>


                            {{-- Notes --}}
                            <div class="col-12">

                                <label
                                    for="engagementNotes"
                                    class="form-label">
                                    Notes
                                </label>

                                <textarea
                                    name="notes"
                                    id="engagementNotes"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Add any relevant notes..."></textarea>

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
                            Create Engagement
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Edit Engagement Modal --}}

    <div
        class="modal fade"
        id="editEngagementModal"
        tabindex="-1"
        aria-labelledby="editEngagementModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5
                            class="modal-title fw-semibold"
                            id="editEngagementModalLabel">
                            Edit Engagement
                        </h5>

                        <small class="text-muted">
                            Update the engagement information.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>


                <form
                    id="editEngagementForm"
                    method="POST">

                    @csrf

                    <div class="modal-body">

                        <div
                            id="editEngagementFormErrors"
                            class="alert alert-danger d-none"></div>

                        <input
                            type="hidden"
                            id="editEngagementId">


                        <div class="row g-3">

                            {{-- Client --}}
                            <div class="col-12">

                                <label
                                    for="editEngagementClient"
                                    class="form-label">
                                    Client
                                </label>

                                <select
                                    id="editEngagementClient"
                                    name="client_id"
                                    class="form-select"
                                    required>

                                    @foreach ($clients as $client)

                                    <option value="{{ $client->id }}">
                                        {{ $client->name }}
                                    </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Service Type --}}
                            <div class="col-md-6">

                                <label
                                    for="editEngagementServiceType"
                                    class="form-label">
                                    Service Type
                                </label>

                                <select
                                    id="editEngagementServiceType"
                                    name="service_type"
                                    class="form-select"
                                    required>

                                    <option value="Tax Preparation">
                                        Tax Preparation
                                    </option>

                                    <option value="Bookkeeping">
                                        Bookkeeping
                                    </option>

                                    <option value="Tax Consultation">
                                        Tax Consultation
                                    </option>

                                    <option value="Payroll">
                                        Payroll
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>

                                </select>

                            </div>


                            {{-- Tax Year --}}
                            <div class="col-md-6">

                                <label
                                    for="editEngagementTaxYear"
                                    class="form-label">
                                    Tax Year
                                </label>

                                <input
                                    type="number"
                                    id="editEngagementTaxYear"
                                    name="tax_year"
                                    class="form-control"
                                    min="2000"
                                    max="2100"
                                    required>

                            </div>


                            {{-- Start Date --}}
                            <div class="col-md-6">

                                <label
                                    for="editEngagementStartDate"
                                    class="form-label">
                                    Start Date
                                </label>

                                <input
                                    type="date"
                                    id="editEngagementStartDate"
                                    name="start_date"
                                    class="form-control"
                                    required>

                            </div>


                            {{-- Due Date --}}
                            <div class="col-md-6">

                                <label
                                    for="editEngagementDueDate"
                                    class="form-label">
                                    Due Date
                                </label>

                                <input
                                    type="date"
                                    id="editEngagementDueDate"
                                    name="due_date"
                                    class="form-control"
                                    required>

                            </div>


                            {{-- Status --}}
                            <div class="col-md-6">

                                <label
                                    for="editEngagementStatus"
                                    class="form-label">
                                    Status
                                </label>

                                <select
                                    id="editEngagementStatus"
                                    name="status"
                                    class="form-select"
                                    required>

                                    <option value="Open">
                                        Open
                                    </option>

                                    <option value="In Progress">
                                        In Progress
                                    </option>

                                    <option value="Completed">
                                        Completed
                                    </option>

                                    <option value="Cancelled">
                                        Cancelled
                                    </option>

                                </select>

                            </div>


                            {{-- Notes --}}
                            <div class="col-12">

                                <label
                                    for="editEngagementNotes"
                                    class="form-label">
                                    Notes
                                </label>

                                <textarea
                                    id="editEngagementNotes"
                                    name="notes"
                                    class="form-control"
                                    rows="4"></textarea>

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
                            Update Engagement
                        </button>

                    </div>

                </form>

            </div>

        </div>


    </div>


</body>

</html>