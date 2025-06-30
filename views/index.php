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

<script src="public/js/app.js"></script>
