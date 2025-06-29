<table class="table table-bordered table-striped align-middle" id="users_table">
  <thead class="table-light">
    <tr>
      <th>Name</th>
      <th>E-mail</th>
      <th>City</th>
      <th>Phone Number</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($users) === 0): ?>
      <tr><td colspan="4" class="text-center"><em>No users found.</em></td></tr>
    <?php else: ?>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user->getName()) ?></td>
          <td><?= htmlspecialchars($user->getEmail()) ?></td>
          <td><?= htmlspecialchars($user->getCity()) ?></td>
          <td><?= $user->getPhoneNumber() ? htmlspecialchars($user->getPhoneNumber()) : '' ?></td>
          <td class="text-center">
            <button class="btn btn-sm btn-warning update-user" data-id="<?= $user->getId() ?>">
              <img src="public/icons/update.svg" alt="Update" style="width: 16px; height: 16px; color: #fffff;">
            </button>
            <button class="btn btn-sm btn-danger delete-user" data-id="<?= $user->getId() ?>" data-page="<?= $page ?>" data-csrf="<?= $csrfToken ?>">
              <img src="public/icons/delete.svg" alt="Delete" style="width: 16px; height: 16px; color: #fffff;">
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<nav class="text-center mt-3">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a href="javascript:void(0);" class="page-link page-link" data-page="<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

