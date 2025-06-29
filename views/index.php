
<h1 class="text-center" id="app-title">User Management</h1>

<div class="text-right mb-5">
  <button class="btn btn-success" data-toggle="modal" data-target="#createUserModal">
	Create User
  </button>
</div>

<div class="mb-5 mt-5">
  <input type="text" name="search" id="search-input" class="form-control" placeholder="Search by city..." value="<?= htmlspecialchars($searchTerm) ?>">
</div>

<div class="loader"></div>

<div id="user-table-wrapper" class="mb-5 mt-5">
  <?php $app->renderPartial('partials/users_table', [
    'users' => $users,
    'page' => $page,
    'totalPages' => $totalPages,
	'csrfToken' => $csrfToken,
	'searchTerm' => $searchTerm
  ]); ?>
</div>

<!-- Extract in partial (won't be done for now to not go over the 4h) -->
<div id="createUserModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New User</h4>
      </div>

      <div class="modal-body">
        <form id="user-form">
	    	<input type="hidden" name="csrf_token" id="csrf-token-create" value="<?= $csrfToken ?>">

          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input name="name" type="text" id="name" class="form-control" required>
          </div>

          <div class="form-group">
			<label for="email">E-mail <span class="text-danger">*</span></label>
			<input name="email" type="email" id="email" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="city">City <span class="text-danger">*</span></label>
            <input name="city" type="text" id="city" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="phone">Phone Number <span class="text-muted">(optional)</span></label>
            <input name="phone_number" type="text" id="phone" class="form-control">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="submit" form="user-form" class="btn btn-success">Create</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<!-- Extract in partial (won't be done for now to not go over the 4h) -->
<div id="editUserModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit User</h4>
      </div>

      <div class="modal-body">
        <form id="edit-user-form">
		  <input type="hidden" name="csrf_token" id="csrf-token-edit" value="<?= $csrfToken ?>">

          <input type="hidden" id="edit-user-id">

          <div class="form-group">
            <label for="edit-name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit-name" required>
          </div>

          <div class="form-group">
            <label for="edit-email">E-mail <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="edit-email" required>
          </div>

          <div class="form-group">
            <label for="edit-city">City <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit-city" required>
          </div>

          <div class="form-group">
            <label for="edit-phone">Phone Number</label>
            <input type="text" class="form-control" id="edit-phone">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" id="save-edit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<script src="jquery.min.js"></script>
<script>
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
</script>
