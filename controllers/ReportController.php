<?php
class ReportController extends Controller {
    
    public function index() {
        $ordinanceModel = new Ordinance();
        $resolutionModel = new Resolution();
        $minuteModel = new Minute();
        
        $data = [
            'ordinance_years' => $ordinanceModel->getYears(),
            'resolution_years' => $resolutionModel->getYears(),
            'minute_years' => $minuteModel->getYears()
        ];
        
        $this->loadView('reports/index', $data);
    }
    
    public function ordinances() {
        $year = $_GET['year'] ?? date('Y');
        $format = $_GET['format'] ?? 'pdf';
        
        $ordinanceModel = new Ordinance();
        $ordinances = $ordinanceModel->getByYear($year);
        
        if ($format === 'excel') {
            $this->generateOrdinanceExcel($ordinances, $year);
        } else {
            $this->generateOrdinancePDF($ordinances, $year);
        }
    }
    
    public function resolutions() {
        $year = $_GET['year'] ?? date('Y');
        $format = $_GET['format'] ?? 'pdf';
        
        $resolutionModel = new Resolution();
        $resolutions = $resolutionModel->getByYear($year);
        
        if ($format === 'excel') {
            $this->generateResolutionExcel($resolutions, $year);
        } else {
            $this->generateResolutionPDF($resolutions, $year);
        }
    }
    
    public function councilor_summary() {
        $year = $_GET['year'] ?? date('Y');
        $format = $_GET['format'] ?? 'pdf';
        
        $councilorModel = new Councilor();
        $councilors = $councilorModel->getActive();
        
        $summary_data = [];
        foreach ($councilors as $councilor) {
            $ordinances = $councilorModel->getOrdinances($councilor['id']);
            $resolutions = $councilorModel->getResolutions($councilor['id']);
            
            // Filter by year
            $ordinances_year = array_filter($ordinances, function($ord) use ($year) {
                return date('Y', strtotime($ord['date_passed'])) == $year;
            });
            
            $resolutions_year = array_filter($resolutions, function($res) use ($year) {
                return date('Y', strtotime($res['date_approved'])) == $year;
            });
            
            $summary_data[] = [
                'councilor' => $councilor,
                'ordinances_count' => count($ordinances_year),
                'resolutions_count' => count($resolutions_year),
                'ordinances' => $ordinances_year,
                'resolutions' => $resolutions_year
            ];
        }
        
        if ($format === 'excel') {
            $this->generateCouncilorSummaryExcel($summary_data, $year);
        } else {
            $this->generateCouncilorSummaryPDF($summary_data, $year);
        }
    }
    
    private function generateOrdinancePDF($ordinances, $year) {
        header('Content-Type: text/html');
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Ordinances Report ' . $year . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Municipality of Baggao</h1>
                <h2>Ordinances Report for ' . $year . '</h2>
                <p>Generated on: ' . date('F d, Y') . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Ordinance No.</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date Passed</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($ordinances as $ordinance) {
            $html .= '<tr>
                <td>' . htmlspecialchars($ordinance['ordinance_number']) . '</td>
                <td>' . htmlspecialchars($ordinance['title']) . '</td>
                <td>' . htmlspecialchars($ordinance['author_name']) . '</td>
                <td>' . date('F d, Y', strtotime($ordinance['date_passed'])) . '</td>
                <td class="text-center">' . ucfirst($ordinance['status']) . '</td>
            </tr>';
        }
        
        $html .= '</tbody>
            </table>
            
            <p style="margin-top: 30px;"><strong>Total Ordinances: ' . count($ordinances) . '</strong></p>
        </body>
        </html>';
        
        header('Content-Disposition: attachment; filename="Ordinances_Report_' . $year . '.html"');
        echo $html;
        exit();
    }
    
    private function generateOrdinanceExcel($ordinances, $year) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Ordinances_Report_' . $year . '.xls"');
        
        echo '<table border="1">
            <tr>
                <th>Ordinance No.</th>
                <th>Title</th>
                <th>Author</th>
                <th>Date Passed</th>
                <th>Status</th>
            </tr>';
        
        foreach ($ordinances as $ordinance) {
            echo '<tr>
                <td>' . htmlspecialchars($ordinance['ordinance_number']) . '</td>
                <td>' . htmlspecialchars($ordinance['title']) . '</td>
                <td>' . htmlspecialchars($ordinance['author_name']) . '</td>
                <td>' . date('F d, Y', strtotime($ordinance['date_passed'])) . '</td>
                <td>' . ucfirst($ordinance['status']) . '</td>
            </tr>';
        }
        
        echo '</table>';
        exit();
    }
    
    private function generateResolutionPDF($resolutions, $year) {
        header('Content-Type: text/html');
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Resolutions Report ' . $year . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Municipality of Baggao</h1>
                <h2>Resolutions Report for ' . $year . '</h2>
                <p>Generated on: ' . date('F d, Y') . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Resolution No.</th>
                        <th>Subject</th>
                        <th>Author</th>
                        <th>Date Approved</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($resolutions as $resolution) {
            $html .= '<tr>
                <td>' . htmlspecialchars($resolution['resolution_number']) . '</td>
                <td>' . htmlspecialchars($resolution['subject']) . '</td>
                <td>' . htmlspecialchars($resolution['author_name']) . '</td>
                <td>' . date('F d, Y', strtotime($resolution['date_approved'])) . '</td>
                <td class="text-center">' . ucfirst($resolution['status']) . '</td>
            </tr>';
        }
        
        $html .= '</tbody>
            </table>
            
            <p style="margin-top: 30px;"><strong>Total Resolutions: ' . count($resolutions) . '</strong></p>
        </body>
        </html>';
        
        header('Content-Disposition: attachment; filename="Resolutions_Report_' . $year . '.html"');
        echo $html;
        exit();
    }
    
    private function generateResolutionExcel($resolutions, $year) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Resolutions_Report_' . $year . '.xls"');
        
        echo '<table border="1">
            <tr>
                <th>Resolution No.</th>
                <th>Subject</th>
                <th>Author</th>
                <th>Date Approved</th>
                <th>Status</th>
            </tr>';
        
        foreach ($resolutions as $resolution) {
            echo '<tr>
                <td>' . htmlspecialchars($resolution['resolution_number']) . '</td>
                <td>' . htmlspecialchars($resolution['subject']) . '</td>
                <td>' . htmlspecialchars($resolution['author_name']) . '</td>
                <td>' . date('F d, Y', strtotime($resolution['date_approved'])) . '</td>
                <td>' . ucfirst($resolution['status']) . '</td>
            </tr>';
        }
        
        echo '</table>';
        exit();
    }
    
    private function generateCouncilorSummaryPDF($summary_data, $year) {
        header('Content-Type: text/html');
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Councilor Contributions Report ' . $year . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Municipality of Baggao</h1>
                <h2>Councilor Contributions Report for ' . $year . '</h2>
                <p>Generated on: ' . date('F d, Y') . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Councilor</th>
                        <th>Position</th>
                        <th>Ordinances</th>
                        <th>Resolutions</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($summary_data as $data) {
            $total = $data['ordinances_count'] + $data['resolutions_count'];
            $html .= '<tr>
                <td>' . htmlspecialchars($data['councilor']['name']) . '</td>
                <td>' . htmlspecialchars($data['councilor']['position']) . '</td>
                <td class="text-center">' . $data['ordinances_count'] . '</td>
                <td class="text-center">' . $data['resolutions_count'] . '</td>
                <td class="text-center"><strong>' . $total . '</strong></td>
            </tr>';
        }
        
        $html .= '</tbody>
            </table>
        </body>
        </html>';
        
        header('Content-Disposition: attachment; filename="Councilor_Summary_' . $year . '.html"');
        echo $html;
        exit();
    }
    
    private function generateCouncilorSummaryExcel($summary_data, $year) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Councilor_Summary_' . $year . '.xls"');
        
        echo '<table border="1">
            <tr>
                <th>Councilor</th>
                <th>Position</th>
                <th>Ordinances</th>
                <th>Resolutions</th>
                <th>Total</th>
            </tr>';
        
        foreach ($summary_data as $data) {
            $total = $data['ordinances_count'] + $data['resolutions_count'];
            echo '<tr>
                <td>' . htmlspecialchars($data['councilor']['name']) . '</td>
                <td>' . htmlspecialchars($data['councilor']['position']) . '</td>
                <td>' . $data['ordinances_count'] . '</td>
                <td>' . $data['resolutions_count'] . '</td>
                <td>' . $total . '</td>
            </tr>';
        }
        
        echo '</table>';
        exit();
    }
}
?>
