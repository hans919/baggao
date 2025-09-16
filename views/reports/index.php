<?php 
$current_page = 'reports';
$title = 'Reports - Baggao Legislative Information System';
ob_start(); 
?>


<div class="row g-4">
    <!-- Ordinances Report -->
    <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-primary bg-opacity-10 border-0 p-4">
                <h5 class="mb-0 fw-semibold d-flex align-items-center text-primary">
                    <i class="bi bi-file-text me-2"></i>Ordinances Report
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">Generate reports of ordinances by year in PDF or Excel format.</p>
                
                <form method="GET" action="<?= BASE_URL ?>reports/ordinances" class="mb-3">
                    <div class="mb-3">
                        <label for="ord_year" class="form-label">Select Year</label>
                        <select class="form-select" id="ord_year" name="year" required>
                            <option value="">Choose Year</option>
                            <?php foreach ($ordinance_years as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="ord_format" class="form-label">Format</label>
                        <select class="form-select" id="ord_format" name="format">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-download"></i> Generate Report
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Resolutions Report -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-check me-2"></i>Resolutions Report</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Generate reports of resolutions by year in PDF or Excel format.</p>
                
                <form method="GET" action="<?= BASE_URL ?>reports/resolutions" class="mb-3">
                    <div class="mb-3">
                        <label for="res_year" class="form-label">Select Year</label>
                        <select class="form-select" id="res_year" name="year" required>
                            <option value="">Choose Year</option>
                            <?php foreach ($resolution_years as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="res_format" class="form-label">Format</label>
                        <select class="form-select" id="res_format" name="format">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-download"></i> Generate Report
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Councilor Contributions Report -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Councilor Contributions</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Generate summary report of councilor contributions by year.</p>
                
                <form method="GET" action="<?= BASE_URL ?>reports/councilor_summary" class="mb-3">
                    <div class="mb-3">
                        <label for="coun_year" class="form-label">Select Year</label>
                        <select class="form-select" id="coun_year" name="year" required>
                            <option value="">Choose Year</option>
                            <?php 
                            $all_years = array_unique(array_merge($ordinance_years, $resolution_years));
                            rsort($all_years);
                            foreach ($all_years as $year): 
                            ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="coun_format" class="form-label">Format</label>
                        <select class="form-select" id="coun_format" name="format">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bi bi-download"></i> Generate Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Additional Report Options -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Report Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="text-primary">Ordinances Report</h6>
                        <ul class="small text-muted">
                            <li>Ordinance number and title</li>
                            <li>Author and date passed</li>
                            <li>Status information</li>
                            <li>Organized by year</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-success">Resolutions Report</h6>
                        <ul class="small text-muted">
                            <li>Resolution number and subject</li>
                            <li>Author and date approved</li>
                            <li>Status information</li>
                            <li>Organized by year</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-warning">Councilor Contributions</h6>
                        <ul class="small text-muted">
                            <li>Councilor name and position</li>
                            <li>Number of ordinances authored</li>
                            <li>Number of resolutions authored</li>
                            <li>Total contributions per year</li>
                        </ul>
                    </div>
                </div>
                
                <hr>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> Reports are generated in real-time based on the current database content. 
                    PDF reports are formatted for printing, while Excel reports allow for further data analysis.
                </div>
            </div>
        </div>
    </div>
</div>
