<?php
$current_admin_page = 'resolutions';
$page_title = 'Resolutions';
$page_description = 'Manage municipal resolutions and decisions';
$breadcrumbs = [
    ['title' => 'Resolutions', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <!-- Additional filters could go here -->
    </div>
    <a href="<?= BASE_URL ?>admin/add_resolution" class="btn btn-success d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i>Add New Resolution
    </a>
</div>

<!-- Resolutions Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                <i class="bi bi-file-earmark-check me-2 text-success"></i>All Resolutions
            </h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?status=approved">Approved</a></li>
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
        <?php if (!empty($resolutions)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Resolution Number</th>
                            <th class="fw-semibold">Subject</th>
                            <th class="fw-semibold">Author</th>
                            <th class="fw-semibold">Date Approved</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resolutions as $resolution): ?>
                            <tr>
                                <td class="fw-medium text-success"><?= htmlspecialchars($resolution['resolution_number']) ?></td>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars(substr($resolution['subject'], 0, 50)) ?><?= strlen($resolution['subject']) > 50 ? '...' : '' ?></div>
                                    <?php if (!empty($resolution['summary'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars(substr($resolution['summary'], 0, 80)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                            <i class="bi bi-person-fill text-success"></i>
                                        </div>
                                        <span><?= htmlspecialchars($resolution['author_name']) ?></span>
                                    </div>
                                </td>
                                <td class="text-muted"><?= date('M j, Y', strtotime($resolution['date_approved'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $resolution['status'] === 'approved' ? 'success' : ($resolution['status'] === 'pending' ? 'warning' : 'danger') ?> px-2 py-1">
                                        <?= ucfirst($resolution['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>resolutions/view/<?= $resolution['id'] ?>" class="btn btn-outline-success" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_resolution/<?= $resolution['id'] ?>" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="deleteItem('resolutions', <?= $resolution['id'] ?>)" title="Delete">
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
                <i class="bi bi-file-earmark-check display-4 text-muted opacity-50"></i>
                <h5 class="mt-3 text-muted">No resolutions found</h5>
                <p class="text-muted mb-4">Start by creating your first resolution.</p>
                <a href="<?= BASE_URL ?>admin/add_resolution" class="btn btn-success">
                    <i class="bi bi-plus-lg me-2"></i>Add New Resolution
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteItem(type, id) {
    if (confirm('Are you sure you want to delete this ' + type.slice(0, -1) + '? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>admin/delete/' + type + '/' + id;
        
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
