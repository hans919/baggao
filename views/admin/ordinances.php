<?php
$current_admin_page = 'ordinances';
$page_title = 'Ordinances';
$page_description = 'Manage municipal ordinances and local laws';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <!-- Additional filters could go here -->
    </div>
    <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i>Add New Ordinance
    </a>
</div>

<!-- Ordinances Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                <i class="bi bi-file-text me-2 text-primary"></i>All Ordinances
            </h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?status=passed">Passed</a></li>
                        <li><a class="dropdown-item" href="?status=pending">Pending</a></li>
                        <li><a class="dropdown-item" href="?status=rejected">Rejected</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?">All Status</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($ordinances)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Ordinance Number</th>
                            <th class="fw-semibold">Title</th>
                            <th class="fw-semibold">Author</th>
                            <th class="fw-semibold">Date Passed</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordinances as $ordinance): ?>
                            <tr>
                                <td class="fw-medium text-primary"><?= htmlspecialchars($ordinance['ordinance_number']) ?></td>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars(substr($ordinance['title'] ?? '', 0, 50)) ?><?= strlen($ordinance['title'] ?? '') > 50 ? '...' : '' ?></div>
                                    <?php if (!empty($ordinance['summary'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars(substr($ordinance['summary'], 0, 80)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-1 me-2">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <span><?= htmlspecialchars($ordinance['author_name'] ?? 'Unknown') ?></span>
                                    </div>
                                </td>
                                <td class="text-muted"><?= date('M j, Y', strtotime($ordinance['date_passed'] ?? 'now')) ?></td>
                                <td>
                                    <span class="badge bg-<?= $ordinance['status'] === 'passed' ? 'success' : ($ordinance['status'] === 'pending' ? 'warning' : 'danger') ?> px-2 py-1">
                                        <?= ucfirst($ordinance['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
        <a href="<?= BASE_URL ?>admin/edit_ordinance/<?= $ordinance['id'] ?>" class="btn btn-outline-secondary" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>
        <button class="btn btn-outline-danger" onclick="deleteItem('ordinances', <?= $ordinance['id'] ?>)" title="Delete">
            <i class="bi bi-trash"></i>
        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-file-text display-4 text-muted opacity-50"></i>
                <h5 class="mt-3 text-muted">No ordinances found</h5>
                <p class="text-muted mb-4">Start by creating your first ordinance.</p>
                <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Add New Ordinance
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteItem(type, id) {
    if (confirm('Are you sure you want to delete this ' + type.slice(0, -1) + '? This action cannot be undone.')) {
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>admin/delete/' + type + '/' + id;
        
        // Add CSRF token if available
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken.getAttribute('content');
            form.appendChild(tokenInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
