<?php
/**
 * Modern Table Component for Admin Interface
 * Inspired by TanStack Table UI patterns
 */
?>

<div class="table-container">
    <!-- Table Header Controls -->
    <div class="table-header">
        <div class="table-title-section">
            <h2 class="table-title"><?= htmlspecialchars($table_title ?? 'Data Table') ?></h2>
            <p class="table-description"><?= htmlspecialchars($table_description ?? '') ?></p>
        </div>
        
        <div class="table-actions">
            <!-- View Mode Toggle -->
            <div class="btn-group btn-group-sm me-2" role="group">
                <input type="radio" class="btn-check" name="tableView" id="tableViewMode" checked>
                <label class="btn btn-outline-secondary" for="tableViewMode" title="Table View">
                    <i class="bi bi-table"></i>
                </label>
                <input type="radio" class="btn-check" name="tableView" id="cardViewMode">
                <label class="btn btn-outline-secondary" for="cardViewMode" title="Card View">
                    <i class="bi bi-grid-3x3-gap"></i>
                </label>
            </div>

            <!-- Density Toggle -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-list-ul me-1"></i>Density
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-density="compact">Compact</a></li>
                    <li><a class="dropdown-item active" href="#" data-density="normal">Normal</a></li>
                    <li><a class="dropdown-item" href="#" data-density="spacious">Spacious</a></li>
                </ul>
            </div>

            <!-- Column Visibility -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-eye me-1"></i>Columns
                </button>
                <ul class="dropdown-menu column-visibility-menu">
                    <?php foreach ($table_columns ?? [] as $column): ?>
                        <li>
                            <div class="dropdown-item-text">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="col-<?= htmlspecialchars($column['key']) ?>" 
                                           <?= $column['visible'] ?? true ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="col-<?= htmlspecialchars($column['key']) ?>">
                                        <?= htmlspecialchars($column['label']) ?>
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Export Options -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-1"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-export="csv">
                        <i class="bi bi-filetype-csv me-2"></i>CSV
                    </a></li>
                    <li><a class="dropdown-item" href="#" data-export="excel">
                        <i class="bi bi-filetype-xlsx me-2"></i>Excel
                    </a></li>
                    <li><a class="dropdown-item" href="#" data-export="pdf">
                        <i class="bi bi-filetype-pdf me-2"></i>PDF
                    </a></li>
                </ul>
            </div>

            <!-- Add New Button -->
            <?php if (isset($add_new_url)): ?>
                <a href="<?= htmlspecialchars($add_new_url) ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus me-1"></i>Add New
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="table-toolbar">
        <div class="search-section">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control search-input" 
                       placeholder="Search <?= strtolower($table_title ?? 'records') ?>..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-ghost clear-search" type="button">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>

        <div class="filter-section">
            <!-- Status Filter -->
            <select class="form-select form-select-sm filter-select" data-filter="status">
                <option value="">All Status</option>
                <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="draft" <?= ($_GET['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="archived" <?= ($_GET['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>

            <!-- Date Range Filter -->
            <input type="date" class="form-control form-control-sm filter-input" 
                   data-filter="date_from" placeholder="From Date"
                   value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
            
            <input type="date" class="form-control form-control-sm filter-input" 
                   data-filter="date_to" placeholder="To Date"
                   value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">

            <!-- Clear Filters -->
            <button class="btn btn-outline-secondary btn-sm clear-filters" type="button">
                <i class="bi bi-funnel me-1"></i>Clear
            </button>
        </div>
    </div>

    <!-- Table Stats -->
    <div class="table-stats">
        <div class="stats-left">
            <span class="stats-text">
                Showing <?= number_format($pagination['from'] ?? 1) ?> to <?= number_format($pagination['to'] ?? 0) ?> 
                of <?= number_format($pagination['total'] ?? 0) ?> results
            </span>
            <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                <span class="search-badge">
                    <i class="bi bi-search me-1"></i>
                    "<?= htmlspecialchars($_GET['search']) ?>"
                    <button class="btn-close btn-close-sm ms-1" type="button" onclick="clearSearch()"></button>
                </span>
            <?php endif; ?>
        </div>

        <div class="stats-right">
            <!-- Rows per page -->
            <div class="rows-per-page">
                <label class="form-label me-2">Rows:</label>
                <select class="form-select form-select-sm" style="width: auto;" onchange="changeRowsPerPage(this.value)">
                    <option value="10" <?= ($_GET['per_page'] ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($_GET['per_page'] ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($_GET['per_page'] ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($_GET['per_page'] ?? 10) == 100 ? 'selected' : '' ?>>100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-wrapper">
        <table class="table modern-table" id="dataTable">
            <thead class="table-header-group">
                <tr>
                    <!-- Select All Checkbox -->
                    <th class="select-column">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                    </th>
                    
                    <?php foreach ($table_columns ?? [] as $column): ?>
                        <?php if ($column['visible'] ?? true): ?>
                            <th class="sortable <?= $column['sortable'] ?? true ? 'cursor-pointer' : '' ?>" 
                                data-sort="<?= htmlspecialchars($column['key']) ?>">
                                <div class="th-content">
                                    <span class="column-label"><?= htmlspecialchars($column['label']) ?></span>
                                    <?php if ($column['sortable'] ?? true): ?>
                                        <span class="sort-icon">
                                            <i class="bi bi-arrow-down-up"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <!-- Actions Column -->
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php if (empty($table_data ?? [])): ?>
                    <tr class="empty-state">
                        <td colspan="<?= count($table_columns ?? []) + 2 ?>" class="text-center py-5">
                            <div class="empty-illustration">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No data found</h5>
                                <p class="text-muted">Try adjusting your search or filter criteria</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($table_data as $row): ?>
                        <tr class="table-row" data-id="<?= htmlspecialchars($row['id'] ?? '') ?>">
                            <!-- Select Checkbox -->
                            <td class="select-cell">
                                <div class="form-check">
                                    <input class="form-check-input row-select" type="checkbox" 
                                           value="<?= htmlspecialchars($row['id'] ?? '') ?>">
                                </div>
                            </td>
                            
                            <?php foreach ($table_columns ?? [] as $column): ?>
                                <?php if ($column['visible'] ?? true): ?>
                                    <td class="data-cell" data-column="<?= htmlspecialchars($column['key']) ?>">
                                        <?php
                                        $value = $row[$column['key']] ?? '';
                                        if (isset($column['format'])) {
                                            switch ($column['format']) {
                                                case 'date':
                                                    echo $value ? date('M j, Y', strtotime($value)) : '-';
                                                    break;
                                                case 'badge':
                                                    $badgeClass = $column['badge_map'][$value] ?? 'secondary';
                                                    echo "<span class='badge bg-{$badgeClass}'>" . htmlspecialchars($value) . "</span>";
                                                    break;
                                                case 'truncate':
                                                    echo strlen($value) > 50 ? htmlspecialchars(substr($value, 0, 50)) . '...' : htmlspecialchars($value);
                                                    break;
                                                default:
                                                    echo htmlspecialchars($value);
                                            }
                                        } else {
                                            echo htmlspecialchars($value);
                                        }
                                        ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <!-- Actions -->
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a href="<?= BASE_URL . ($edit_url_pattern ?? 'admin/edit/') . ($row['id'] ?? '') ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL . ($view_url_pattern ?? 'admin/view/') . ($row['id'] ?? '') ?>" 
                                       class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteRecord(<?= htmlspecialchars($row['id'] ?? '') ?>)" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
        <div class="table-pagination">
            <nav aria-label="Table pagination">
                <ul class="pagination pagination-sm mb-0">
                    <!-- Previous Page -->
                    <li class="page-item <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $pagination['prev_url'] ?? '#' ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    
                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                        <?php if ($i == $pagination['current_page']): ?>
                            <li class="page-item active">
                                <span class="page-link"><?= $i ?></span>
                            </li>
                        <?php elseif (abs($i - $pagination['current_page']) <= 2 || $i == 1 || $i == $pagination['total_pages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $pagination['base_url'] ?>?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php elseif (abs($i - $pagination['current_page']) == 3): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <!-- Next Page -->
                    <li class="page-item <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $pagination['next_url'] ?? '#' ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

    <!-- Bulk Actions Bar (Hidden by default) -->
    <div class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-content">
            <span class="selected-count">0 items selected</span>
            <div class="bulk-actions">
                <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
                    <i class="bi bi-trash me-1"></i>Delete Selected
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="bulkExport()">
                    <i class="bi bi-download me-1"></i>Export Selected
                </button>
            </div>
            <button class="btn btn-sm btn-ghost" onclick="clearSelection()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
</div>