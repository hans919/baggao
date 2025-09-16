<?php
$current_admin_page = 'minutes';
$page_title = 'Meeting Minutes';
$page_description = 'Manage municipal meeting records and proceedings';
$breadcrumbs = [
    ['title' => 'Meeting Minutes', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <!-- Additional filters could go here -->
    </div>
    <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-info d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i>Add New Minutes
    </a>
</div>

<!-- Success Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success border-0 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Minutes Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                <i class="bi bi-journal-text me-2 text-info"></i>All Meeting Minutes
            </h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?status=published">Published</a></li>
                        <li><a class="dropdown-item" href="?status=draft">Draft</a></li>
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
        <?php if (!empty($minutes)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Meeting Date</th>
                            <th class="fw-semibold">Session Type</th>
                            <th class="fw-semibold">Summary</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($minutes as $minute): ?>
                            <tr>
                                <td class="fw-medium text-info"><?= date('M j, Y', strtotime($minute['meeting_date'])) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-1 me-2">
                                            <i class="bi bi-calendar3 text-info"></i>
                                        </div>
                                        <span><?= htmlspecialchars($minute['session_type']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars(substr($minute['summary'], 0, 50)) ?><?= strlen($minute['summary']) > 50 ? '...' : '' ?></div>
                                    <?php if (!empty($minute['agenda_items'])): ?>
                                        <small class="text-muted"><?= count(explode(',', $minute['agenda_items'])) ?> agenda items</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $minute['status'] === 'published' ? 'success' : 'secondary' ?> px-2 py-1">
                                        <?= ucfirst($minute['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>minutes/view/<?= $minute['id'] ?>" class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_minute/<?= $minute['id'] ?>" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="deleteMinute(<?= $minute['id'] ?>)" title="Delete">
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
                <i class="bi bi-journal-text display-4 text-muted opacity-50"></i>
                <h5 class="mt-3 text-muted">No meeting minutes found</h5>
                <p class="text-muted mb-4">Start by recording your first meeting minutes.</p>
                <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-info">
                    <i class="bi bi-plus-lg me-2"></i>Add New Minutes
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteMinute(id) {
    if (confirm('Are you sure you want to delete this meeting minute? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>admin/delete_minute/' + id;
        
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
