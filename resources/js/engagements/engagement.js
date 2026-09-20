import $ from 'jquery';
import * as bootstrap from 'bootstrap';

$('#addEngagementForm').on('submit', function (event) {

event.preventDefault();

const form = $(this);

$.ajax({
    url: form.attr('action'),
    method: 'POST',
    data: form.serialize(),

    success: function (response) {

        console.log(response);

        const engagement = response.data;

        const row = `
            <tr data-engagement-id="${engagement.id}">

                <td class="px-4">
                    <div class="fw-semibold engagement-client">
                        ${engagement.client.name}
                    </div>
                </td>

                <td class="engagement-service-type">
                    ${engagement.service_type}
                </td>

                <td class="engagement-tax-year">
                    ${engagement.tax_year}
                </td>

                <td class="engagement-start-date">
                    ${engagement.start_date}
                </td>

                <td class="engagement-due-date">
                    ${engagement.due_date}
                </td>

                <td>
                    <span class="badge text-bg-primary engagement-status">
                        ${engagement.status}
                    </span>
                </td>

                <td class="text-end px-4">

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary edit-engagement"
                        data-id="${engagement.id}"
                    >
                        Edit
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger delete-engagement"
                        data-id="${engagement.id}"
                    >
                        Delete
                    </button>

                </td>

            </tr>
        `;

        $('#noEngagementsRow').remove();

        $('#engagementTableBody').prepend(row);

        $('#addEngagementForm')[0].reset();

        const modalElement = document.getElementById(
            'addEngagementModal'
        );

        const modal = bootstrap.Modal.getInstance(modalElement);

        modal.hide();
    },

    error: function (xhr) {

        console.log(xhr);

        if (xhr.status === 422) {

            const errors = xhr.responseJSON.errors;

            let errorMessages = '';

            $.each(errors, function (field, messages) {

                $.each(messages, function (index, message) {

                    errorMessages += `
                        <div>${message}</div>
                    `;

                });

            });

            $('#engagementFormErrors')
                .removeClass('d-none')
                .html(errorMessages);

            return;
        }

        $('#engagementFormErrors')
            .removeClass('d-none')
            .text(
                'Something went wrong. Please try again.'
            );
    }
});

});


$(document).on('click', '.edit-engagement', function () {

const engagementId = $(this).data('id');

$.ajax({
    url: `/engagements/${engagementId}`,
    method: 'GET',

    success: function (response) {

        const engagement = response.data;

        $('#editEngagementId').val(engagement.id);

        $('#editEngagementClient')
            .val(engagement.client_id);

        $('#editEngagementServiceType')
            .val(engagement.service_type);

        $('#editEngagementTaxYear')
            .val(engagement.tax_year);

        $('#editEngagementStartDate')
            .val(engagement.start_date);

        $('#editEngagementDueDate')
            .val(engagement.due_date);

        $('#editEngagementStatus')
            .val(engagement.status);

        $('#editEngagementNotes')
            .val(engagement.notes);

        $('#editEngagementFormErrors')
            .addClass('d-none')
            .empty();

        const modalElement = document.getElementById(
            'editEngagementModal'
        );

        const modal = new bootstrap.Modal(modalElement);

        modal.show();
    },

    error: function (xhr) {

        console.log(xhr);

        alert(
            'Unable to load engagement information.'
        );
    }
});

});


$('#editEngagementForm').on('submit', function (event) {

event.preventDefault();

const form = $(this);

const engagementId = $('#editEngagementId').val();

$.ajax({
    url: `/engagements/${engagementId}`,
    method: 'PUT',
    data: form.serialize(),

    success: function (response) {

        console.log(response);

        const engagement = response.data;

        const row = $(
            `tr[data-engagement-id="${engagement.id}"]`
        );

        row.find('.engagement-client')
            .text(engagement.client.name);

        row.find('.engagement-service-type')
            .text(engagement.service_type);

        row.find('.engagement-tax-year')
            .text(engagement.tax_year);

        row.find('.engagement-start-date')
            .text(engagement.start_date);

        row.find('.engagement-due-date')
            .text(engagement.due_date);

        row.find('.engagement-status')
            .text(engagement.status);

        const modalElement = document.getElementById(
            'editEngagementModal'
        );

        const modal = bootstrap.Modal.getInstance(
            modalElement
        );

        modal.hide();

    },

    error: function (xhr) {

        console.log(xhr);

        if (xhr.status === 422) {

            const errors = xhr.responseJSON.errors;

            let errorMessages = '';

            $.each(errors, function (field, messages) {

                $.each(messages, function (index, message) {

                    errorMessages += `
                        <div>${message}</div>
                    `;

                });

            });

            $('#editEngagementFormErrors')
                .removeClass('d-none')
                .html(errorMessages);

            return;
        }

        $('#editEngagementFormErrors')
            .removeClass('d-none')
            .text(
                'Something went wrong. Please try again.'
            );
    }
});

});


$(document).on('click', '.delete-engagement', function () {

const engagementId = $(this).data('id');

const confirmed = confirm(
    'Are you sure you want to delete this engagement?'
);

if (!confirmed) {
    return;
}

$.ajax({
    url: `/engagements/${engagementId}`,
    method: 'DELETE',

    data: {
        _token: $('meta[name="csrf-token"]').attr('content')
    },

    success: function (response) {

        console.log(response);

        const row = $(
            `tr[data-engagement-id="${engagementId}"]`
        );

        row.remove();

        if ($('#engagementTableBody tr').length === 0) {

            $('#engagementTableBody').html(`
                <tr id="noEngagementsRow">
                    <td
                        colspan="7"
                        class="text-center text-muted py-5"
                    >
                        No engagements found.
                    </td>
                </tr>
            `);

        }

    },

    error: function (xhr) {

        console.log(xhr);

        alert(
            'Unable to delete engagement.'
        );
    }
});

});