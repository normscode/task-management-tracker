import $ from 'jquery';
import * as bootstrap from 'bootstrap';

$('#addClientForm').on('submit', function (event) {

    event.preventDefault();

    const form = $(this);

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),

        success: function (response) {
            // console.log(response);
            window.location.reload();
        },

        error: function (xhr) {
            console.log(xhr);
        }
    });

});


$(document).on('click', '.edit-client', function () {

    const clientId = $(this).data('id');

    console.log('Edit clicked:', clientId);

    $.ajax({
        url: `/clients/${clientId}`,
        method: 'GET',

        success: function (response) {

            console.log(response);

            const client = response.data;

            $('#editClientId').val(client.id);
            $('#editName').val(client.name);
            $('#editEmail').val(client.email);
            $('#editPhone').val(client.phone);
            $('#editEntityType').val(client.entity_type);
            $('#editStatus').val(client.status);

            $('#editFormErrors')
                .addClass('d-none')
                .empty();

            const modalElement = document.getElementById('editClientModal');

            const modal = new bootstrap.Modal(modalElement);

            modal.show();
        },

        error: function (xhr) {

            console.log(xhr);

            alert('Unable to load client information.');
        }
    });

});


$('#editClientForm').on('submit', function (event) {

    event.preventDefault();

    const form = $(this);
    const clientId = $('#editClientId').val();

    $.ajax({
        url: `/clients/${clientId}`,
        method: 'PUT',
        data: form.serialize(),

        success: function (response) {

            console.log(response);

            const client = response.data;

            const row = $(`tr[data-client-id="${client.id}"]`);

            row.find('.client-name').text(client.name);
            row.find('.client-email').text(client.email);
            row.find('.client-phone').text(client.phone);
            row.find('.client-entity-type').text(client.entity_type);

            row.find('.client-status')
                .text(client.status)
                .removeClass('text-bg-success text-bg-secondary')
                .addClass(
                    client.status === 'Active'
                        ? 'text-bg-success'
                        : 'text-bg-secondary'
                );

            const modalElement = document.getElementById('editClientModal');
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
                        errorMessages += `<div>${message}</div>`;
                    });

                });

                $('#editFormErrors')
                    .removeClass('d-none')
                    .html(errorMessages);

                return;
            }

            $('#editFormErrors')
                .removeClass('d-none')
                .text('Something went wrong. Please try again.');
        }
    });

});


$(document).on('click', '.archive-client', function () {

    const clientId = $(this).data('id');

    const confirmed = confirm(
        'Are you sure you want to archive this client?'
    );

    if (!confirmed) {
        return;
    }

    $.ajax({
        url: `/clients/${clientId}`,
        method: 'DELETE',

        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function (response) {
            console.log(response);

            window.location.reload();
        },

        error: function (xhr) {
            console.log(xhr);

            alert('Unable to archive client.');
        }
    });
});