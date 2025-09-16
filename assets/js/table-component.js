/**
 * Modern Table Component JavaScript
 * TanStack Table inspired functionality
 */

class ModernTableComponent {
    constructor(tableId = 'dataTable') {
        this.table = document.getElementById(tableId);
        this.container = this.table?.closest('.table-container');
        this.selectedRows = new Set();
        this.currentSort = { column: null, direction: null };
        this.currentFilters = {};
        this.currentSearch = '';
        
        this.init();
    }

    init() {
        if (!this.table) return;

        this.setupEventListeners();
        this.setupColumnVisibility();
        this.setupDensityControl();
        this.setupSearch();
        this.setupFilters();
        this.setupSorting();
        this.setupRowSelection();
        this.setupExportHandlers();
        this.restoreState();
    }

    setupEventListeners() {
        // Select all checkbox
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                this.toggleSelectAll(e.target.checked);
            });
        }

        // Row selection checkboxes
        const rowCheckboxes = document.querySelectorAll('.row-select');
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.toggleRowSelection(e.target.value, e.target.checked);
            });
        });

        // Clear search button
        const clearSearchBtn = this.container?.querySelector('.clear-search');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', () => {
                this.clearSearch();
            });
        }

        // Clear filters button
        const clearFiltersBtn = this.container?.querySelector('.clear-filters');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', () => {
                this.clearFilters();
            });
        }
    }

    setupColumnVisibility() {
        const columnCheckboxes = document.querySelectorAll('.column-visibility-menu input[type="checkbox"]');
        columnCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const columnKey = e.target.id.replace('col-', '');
                this.toggleColumnVisibility(columnKey, e.target.checked);
            });
        });
    }

    setupDensityControl() {
        const densityItems = document.querySelectorAll('[data-density]');
        densityItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const density = e.target.dataset.density;
                this.changeDensity(density);
            });
        });
    }

    setupSearch() {
        const searchInput = this.container?.querySelector('.search-input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.handleSearch(e.target.value);
                }, 300); // Debounce search
            });

            // Show/hide clear button based on input value
            searchInput.addEventListener('input', (e) => {
                const clearBtn = this.container?.querySelector('.clear-search');
                if (clearBtn) {
                    clearBtn.style.opacity = e.target.value ? '1' : '0';
                }
            });
        }
    }

    setupFilters() {
        const filterSelects = this.container?.querySelectorAll('.filter-select');
        const filterInputs = this.container?.querySelectorAll('.filter-input');
        
        [...filterSelects, ...filterInputs].forEach(filter => {
            filter.addEventListener('change', (e) => {
                const filterName = e.target.dataset.filter;
                this.handleFilter(filterName, e.target.value);
            });
        });
    }

    setupSorting() {
        const sortableHeaders = this.table?.querySelectorAll('.sortable');
        sortableHeaders?.forEach(header => {
            header.addEventListener('click', () => {
                const column = header.dataset.sort;
                this.handleSort(column);
            });
        });
    }

    setupRowSelection() {
        // Setup bulk actions
        const bulkActionsBar = this.container?.querySelector('.bulk-actions-bar');
        if (bulkActionsBar) {
            // Initially hidden
            bulkActionsBar.style.display = 'none';
        }
    }

    setupExportHandlers() {
        const exportItems = document.querySelectorAll('[data-export]');
        exportItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const format = e.target.dataset.export || e.target.closest('[data-export]')?.dataset.export;
                this.handleExport(format);
            });
        });
    }

    // Column Visibility
    toggleColumnVisibility(columnKey, visible) {
        const columnElements = this.table?.querySelectorAll(`[data-column="${columnKey}"], th[data-sort="${columnKey}"]`);
        columnElements?.forEach(element => {
            element.style.display = visible ? '' : 'none';
        });

        // Update dropdown item state
        const dropdownItem = document.getElementById(`col-${columnKey}`);
        if (dropdownItem) {
            dropdownItem.closest('.dropdown-item-text').classList.toggle('active', visible);
        }

        this.saveState();
    }

    // Density Control
    changeDensity(density) {
        // Remove existing density classes
        this.container?.classList.remove('density-compact', 'density-normal', 'density-spacious');
        
        // Add new density class
        if (density !== 'normal') {
            this.container?.classList.add(`density-${density}`);
        }

        // Update active state in dropdown
        const densityItems = document.querySelectorAll('[data-density]');
        densityItems.forEach(item => {
            item.classList.remove('active');
            if (item.dataset.density === density) {
                item.classList.add('active');
            }
        });

        this.saveState();
    }

    // Search Functionality
    handleSearch(searchTerm) {
        this.currentSearch = searchTerm;
        this.updateURL();
        this.reloadTable();
    }

    clearSearch() {
        const searchInput = this.container?.querySelector('.search-input');
        if (searchInput) {
            searchInput.value = '';
            this.currentSearch = '';
            this.updateURL();
            this.reloadTable();
        }
    }

    // Filter Functionality
    handleFilter(filterName, filterValue) {
        if (filterValue) {
            this.currentFilters[filterName] = filterValue;
        } else {
            delete this.currentFilters[filterName];
        }
        
        this.updateURL();
        this.reloadTable();
    }

    clearFilters() {
        this.currentFilters = {};
        
        // Clear filter inputs
        const filterSelects = this.container?.querySelectorAll('.filter-select');
        const filterInputs = this.container?.querySelectorAll('.filter-input');
        
        [...filterSelects, ...filterInputs].forEach(filter => {
            filter.value = '';
        });

        this.updateURL();
        this.reloadTable();
    }

    // Sorting Functionality
    handleSort(column) {
        if (this.currentSort.column === column) {
            // Toggle direction
            if (this.currentSort.direction === 'asc') {
                this.currentSort.direction = 'desc';
            } else if (this.currentSort.direction === 'desc') {
                this.currentSort = { column: null, direction: null };
            } else {
                this.currentSort.direction = 'asc';
            }
        } else {
            this.currentSort = { column, direction: 'asc' };
        }

        this.updateSortIcons();
        this.updateURL();
        this.reloadTable();
    }

    updateSortIcons() {
        // Reset all sort icons
        const sortableHeaders = this.table?.querySelectorAll('.sortable');
        sortableHeaders?.forEach(header => {
            header.classList.remove('asc', 'desc');
        });

        // Set active sort icon
        if (this.currentSort.column) {
            const activeHeader = this.table?.querySelector(`[data-sort="${this.currentSort.column}"]`);
            if (activeHeader && this.currentSort.direction) {
                activeHeader.classList.add(this.currentSort.direction);
            }
        }
    }

    // Row Selection
    toggleSelectAll(checked) {
        const rowCheckboxes = this.table?.querySelectorAll('.row-select');
        rowCheckboxes?.forEach(checkbox => {
            checkbox.checked = checked;
            this.toggleRowSelection(checkbox.value, checked);
        });
    }

    toggleRowSelection(rowId, selected) {
        if (selected) {
            this.selectedRows.add(rowId);
        } else {
            this.selectedRows.delete(rowId);
        }

        // Update row visual state
        const row = this.table?.querySelector(`tr[data-id="${rowId}"]`);
        if (row) {
            row.classList.toggle('selected', selected);
        }

        this.updateBulkActions();
        this.updateSelectAllState();
    }

    updateSelectAllState() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = this.table?.querySelectorAll('.row-select');
        
        if (selectAllCheckbox && rowCheckboxes) {
            const checkedCount = Array.from(rowCheckboxes).filter(cb => cb.checked).length;
            const totalCount = rowCheckboxes.length;
            
            selectAllCheckbox.checked = checkedCount === totalCount && totalCount > 0;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    }

    updateBulkActions() {
        const bulkActionsBar = this.container?.querySelector('.bulk-actions-bar');
        const selectedCount = this.container?.querySelector('.selected-count');
        
        if (bulkActionsBar && selectedCount) {
            const count = this.selectedRows.size;
            
            if (count > 0) {
                bulkActionsBar.style.display = 'block';
                selectedCount.textContent = `${count} item${count !== 1 ? 's' : ''} selected`;
            } else {
                bulkActionsBar.style.display = 'none';
            }
        }
    }

    clearSelection() {
        this.selectedRows.clear();
        
        // Uncheck all checkboxes
        const checkboxes = this.table?.querySelectorAll('.row-select, #selectAll');
        checkboxes?.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.indeterminate = false;
        });

        // Remove selected class from rows
        const selectedRows = this.table?.querySelectorAll('.selected');
        selectedRows?.forEach(row => {
            row.classList.remove('selected');
        });

        this.updateBulkActions();
    }

    // Export Functionality
    handleExport(format) {
        const selectedIds = Array.from(this.selectedRows);
        const params = new URLSearchParams({
            export: format,
            ...this.currentFilters,
            search: this.currentSearch,
            ...(this.currentSort.column && { 
                sort: this.currentSort.column,
                direction: this.currentSort.direction 
            }),
            ...(selectedIds.length > 0 && { selected: selectedIds.join(',') })
        });

        // Trigger download
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Bulk Actions
    bulkDelete() {
        if (this.selectedRows.size === 0) return;

        const selectedIds = Array.from(this.selectedRows);
        if (confirm(`Are you sure you want to delete ${selectedIds.length} item(s)?`)) {
            // Implement bulk delete API call
            this.performBulkAction('delete', selectedIds);
        }
    }

    bulkExport() {
        if (this.selectedRows.size === 0) return;
        this.handleExport('csv');
    }

    performBulkAction(action, ids) {
        // Show loading state
        this.container?.classList.add('table-loading');
        
        // Implement your bulk action API call here
        fetch(`${window.location.pathname}/bulk-action`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: action,
                ids: ids
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.clearSelection();
                this.reloadTable();
            } else {
                alert('Error performing bulk action: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Bulk action error:', error);
            alert('Error performing bulk action');
        })
        .finally(() => {
            this.container?.classList.remove('table-loading');
        });
    }

    // URL and State Management
    updateURL() {
        const params = new URLSearchParams(window.location.search);
        
        // Update search
        if (this.currentSearch) {
            params.set('search', this.currentSearch);
        } else {
            params.delete('search');
        }

        // Update filters
        Object.keys(this.currentFilters).forEach(key => {
            params.set(key, this.currentFilters[key]);
        });

        // Update sort
        if (this.currentSort.column && this.currentSort.direction) {
            params.set('sort', this.currentSort.column);
            params.set('direction', this.currentSort.direction);
        } else {
            params.delete('sort');
            params.delete('direction');
        }

        // Update URL without reload
        const newURL = `${window.location.pathname}?${params.toString()}`;
        window.history.replaceState({}, '', newURL);
    }

    reloadTable() {
        // Implement table reload logic
        // This would typically make an AJAX request to reload table data
        console.log('Reloading table with current state:', {
            search: this.currentSearch,
            filters: this.currentFilters,
            sort: this.currentSort
        });
        
        // For now, just reload the page
        // In a real implementation, you'd make an AJAX request
        // and update only the table content
        window.location.reload();
    }

    saveState() {
        // Save current state to localStorage
        const state = {
            density: this.container?.className.match(/density-(\w+)/)?.[1] || 'normal',
            hiddenColumns: this.getHiddenColumns(),
            selectedRows: Array.from(this.selectedRows)
        };
        
        localStorage.setItem('tableState', JSON.stringify(state));
    }

    restoreState() {
        try {
            const savedState = JSON.parse(localStorage.getItem('tableState') || '{}');
            
            // Restore density
            if (savedState.density && savedState.density !== 'normal') {
                this.changeDensity(savedState.density);
            }

            // Restore hidden columns
            if (savedState.hiddenColumns) {
                savedState.hiddenColumns.forEach(columnKey => {
                    this.toggleColumnVisibility(columnKey, false);
                });
            }

            // Parse URL parameters
            const params = new URLSearchParams(window.location.search);
            this.currentSearch = params.get('search') || '';
            
            // Restore filters from URL
            ['status', 'date_from', 'date_to'].forEach(filterName => {
                const value = params.get(filterName);
                if (value) {
                    this.currentFilters[filterName] = value;
                }
            });

            // Restore sort from URL
            const sortColumn = params.get('sort');
            const sortDirection = params.get('direction');
            if (sortColumn && sortDirection) {
                this.currentSort = { column: sortColumn, direction: sortDirection };
                this.updateSortIcons();
            }

        } catch (error) {
            console.error('Error restoring table state:', error);
        }
    }

    getHiddenColumns() {
        const hiddenColumns = [];
        const columnCheckboxes = document.querySelectorAll('.column-visibility-menu input[type="checkbox"]');
        columnCheckboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                hiddenColumns.push(checkbox.id.replace('col-', ''));
            }
        });
        return hiddenColumns;
    }
}

// Global functions for inline event handlers
function changeRowsPerPage(perPage) {
    const params = new URLSearchParams(window.location.search);
    params.set('per_page', perPage);
    params.delete('page'); // Reset to first page
    window.location.href = `${window.location.pathname}?${params.toString()}`;
}

function deleteRecord(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        // Implement delete logic
        fetch(`${window.location.pathname}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error deleting record: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Error deleting record');
        });
    }
}

function clearSearch() {
    const params = new URLSearchParams(window.location.search);
    params.delete('search');
    window.location.href = `${window.location.pathname}?${params.toString()}`;
}

function bulkDelete() {
    if (window.modernTable) {
        window.modernTable.bulkDelete();
    }
}

function bulkExport() {
    if (window.modernTable) {
        window.modernTable.bulkExport();
    }
}

function clearSelection() {
    if (window.modernTable) {
        window.modernTable.clearSelection();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize table component
    window.modernTable = new ModernTableComponent();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + A to select all
        if ((e.ctrlKey || e.metaKey) && e.key === 'a' && e.target.closest('.table-container')) {
            e.preventDefault();
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                selectAllCheckbox.dispatchEvent(new Event('change'));
            }
        }
        
        // Escape to clear selection
        if (e.key === 'Escape' && window.modernTable?.selectedRows.size > 0) {
            window.modernTable.clearSelection();
        }
    });
});