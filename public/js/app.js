let currentPage = 1;

function loadTable(page = 1, searchTerm = '') {
    $('#user-table-wrapper').html('');
    $('.loader').show();
    $.get('users_table.php', { page: page, search_term: searchTerm }, function(html) {
        $('#user-table-wrapper').html(html);
        $('.loader').hide();
    });
}

function showToast(message) {
    const toast = $('<div class="toast-message"></div>').text(message);
    $('#toast-container').append(toast);
    setTimeout(() => {
        toast.fadeOut(400, () => toast.remove());
    }, 3000);
}

$(document).ready(function() {
    $('#user-form').on('submit', function(e) {
        e.preventDefault();

        $.post('create.php', $(this).serialize(), function(response) {
            $('#createUserModal').modal('hide');
            showToast('User created successfully.');
            $('#user-table-wrapper').html(response.html);
            $('#user-form')[0].reset(); // clear form
        }, 'json').fail(function(xhr) {
            const res = xhr.responseJSON;

            if (res && res.errors) {
                showToast(res.errors.join('\n'));
            } else {
                showToast('Unexpected error during user creation.');
            }
        });
    });

    $('#save-edit').on('click', function() {
        document.activeElement.blur();

        const id = $('#edit-user-id').val();
        const data = {
            id: id,
            name: $('#edit-name').val(),
            email: $('#edit-email').val(),
            city: $('#edit-city').val(),
            phone_number: $('#edit-phone').val(),
            page: currentPage,
            csrf_token: $('#csrf-token-edit').val()
        };

        $.post('update.php', data, function(response) {
            if (response.success) {
                $('#editUserModal').modal('hide');
                $('#user-table-wrapper').html(response.html);
                showToast('User updated successfully.');
            } else {
                showToast('Update failed.');
            }
        }, 'json').fail(function(xhr) {
            const res = xhr.responseJSON;

            if (res && res.errors) {
                showToast(res.errors.join('\n'));
            } else {
                showToast('Unexpected error during user update.');
            }
        });
    });

    let searchDebounceTimer = null;
    $('#search-input').on('input', function () {
        clearTimeout(searchDebounceTimer);

        const term = $(this).val().trim();

        searchDebounceTimer = setTimeout(() => {
            const query = (term.length >= 3) ? term : '';
            loadTable(1, query); // reset to page 1 on new search
        }, 300); // 300ms debounce
    });
});

$(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;
    const search = $('#search-input').val().trim();
    loadTable(page, search.length >= 3 ? search : '');
});

$(document).on('click', '.update-user', function() {
    const row = $(this).closest('tr');
    const id = $(this).data('id');

    const name = row.find('td').eq(0).text().trim();
    const email = row.find('td').eq(1).text().trim();
    const city = row.find('td').eq(2).text().trim();
    const phone = row.find('td').eq(3).text().trim();

    $('#edit-user-id').val(id);
    $('#edit-name').val(name);
    $('#edit-email').val(email);
    $('#edit-city').val(city);
    $('#edit-phone').val(phone);

    $('#editUserModal').modal('show');
});

$(document).on('click', '.delete-user', function(e) {
    e.preventDefault();

    const id = $(this).data('id');
    if (!confirm('Are you sure you want to delete this user?')) return;

    const page = $(this).data('page');
    const csrf_token = $(this).data('csrf');

    // Used POST instead of DELETE for simplicity
    $.post('delete.php', { id: id, csrf_token: csrf_token, page: page }, function(response) {
        if (response.success) {
            showToast('User deleted.');
            $('#user-table-wrapper').html(response.html);
        } else {
            showToast('Failed to delete user.');
        }
    }, 'json').fail(function() {
        showToast('Failed to delete user.');
    });
});
