<?php
$current_admin_page = 'comments';
$page_title = 'Manage Comments';
$page_description = 'Review and manage public comments on ordinances';
$breadcrumbs = [
    ['title' => 'Comments', 'url' => '#']
];

ob_start();
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-0 fw-bold">Comments</h5>
            <p class="text-muted small mb-0">Manage public comments on ordinances</p>
        </div>
    </div>
    <div class="card-body p-4">
        <!-- Comment Filters -->
        <div class="mb-4">
            <div class="btn-group" role="group">
                <a href="?status=all" class="btn <?= empty($_GET['status']) || $_GET['status'] === 'all' ? 'btn-primary' : 'btn-outline-primary' ?>">
                    All Comments
                </a>
                <a href="?status=pending" class="btn <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'btn-primary' : 'btn-outline-primary' ?>">
                    Pending
                </a>
                <a href="?status=approved" class="btn <?= isset($_GET['status']) && $_GET['status'] === 'approved' ? 'btn-primary' : 'btn-outline-primary' ?>">
                    Approved
                </a>
                <a href="?status=rejected" class="btn <?= isset($_GET['status']) && $_GET['status'] === 'rejected' ? 'btn-primary' : 'btn-outline-primary' ?>">
                    Rejected
                </a>
            </div>
        </div>

        <!-- Comments List -->
        <?php if (!empty($comments)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Ordinance</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL ?>ordinances/view/<?= $comment['ordinance_id'] ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($comment['ordinance_number']) ?>
                                    </a>
                                </td>
                                <td style="max-width: 300px;">
                                    <div class="text-truncate">
                                        <?= htmlspecialchars($comment['comment_text']) ?>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M d, Y g:i A', strtotime($comment['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $comment['status'] === 'approved' ? 'success' : 
                                        ($comment['status'] === 'pending' ? 'warning text-dark' : 'danger') 
                                    ?>">
                                        <?= ucfirst($comment['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($comment['status'] === 'pending'): ?>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL ?>admin/comments/approve/<?= $comment['id'] ?>" 
                                               class="btn btn-outline-success" title="Approve">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/comments/reject/<?= $comment['id'] ?>" 
                                               class="btn btn-outline-danger" title="Reject">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?= BASE_URL ?>admin/comments/delete/<?= $comment['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger ms-1" 
                                       onclick="return confirm('Are you sure you want to delete this comment?')" 
                                       title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-chat-dots text-muted" style="font-size: 2rem;"></i>
                </div>
                <h6 class="text-muted">No comments found</h6>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>