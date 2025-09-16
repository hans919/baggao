<?php
$current_admin_page = 'publications';
$page_title = 'Publications';
$page_description = 'Manage municipal publications and announcements';
$breadcrumbs = [
    ['title' => 'Publications', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <!-- Additional filters could go here -->
    </div>
    <a href="<?= BASE_URL ?>admin/add_publication" class="btn btn-warning d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i>Add New Publication
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

<!-- Publications Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                <i class="bi bi-megaphone me-2 text-warning"></i>All Publications
            </h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?category=announcement">Announcements</a></li>
                        <li><a class="dropdown-item" href="?category=memo">Memos</a></li>
                        <li><a class="dropdown-item" href="?category=policy">Policies</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?status=published">Published</a></li>
                        <li><a class="dropdown-item" href="?status=draft">Draft</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?">All Items</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($publications)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Title</th>
                            <th class="fw-semibold">Category</th>
                            <th class="fw-semibold">Date Posted</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($publications as $publication): ?>
                            <tr>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars(substr($publication['title'], 0, 50)) ?><?= strlen($publication['title']) > 50 ? '...' : '' ?></div>
                                    <?php if (!empty($publication['content'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars(substr($publication['content'], 0, 80)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-1 me-2">
                                            <i class="bi bi-<?= $publication['category'] === 'announcement' ? 'megaphone' : ($publication['category'] === 'memo' ? 'file-text' : 'clipboard-check') ?> text-warning"></i>
                                        </div>
                                        <span class="badge bg-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : 'secondary') ?> px-2 py-1">
                                            <?= ucfirst(str_replace('_', ' ', $publication['category'])) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-muted"><?= date('M j, Y', strtotime($publication['date_posted'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $publication['status'] === 'published' ? 'success' : 'secondary' ?> px-2 py-1">
                                        <?= ucfirst($publication['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="btn btn-outline-warning" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_publication/<?= $publication['id'] ?>" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" onclick="deleteItem('publications', <?= $publication['id'] ?>)" title="Delete">
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
                <i class="bi bi-megaphone display-4 text-muted opacity-50"></i>
                <h5 class="mt-3 text-muted">No publications found</h5>
                <p class="text-muted mb-4">Start by creating your first publication.</p>
                <a href="<?= BASE_URL ?>admin/add_publication" class="btn btn-warning">
                    <i class="bi bi-plus-lg me-2"></i>Add New Publication
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
