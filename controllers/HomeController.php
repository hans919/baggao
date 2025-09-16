<?php
class HomeController extends Controller {
    
    public function index() {
        $publicationModel = new Publication();
        $ordinanceModel = new Ordinance();
        $resolutionModel = new Resolution();
        $minuteModel = new Minute();
        
        $data = [
            'recent_publications' => $publicationModel->getRecent(3),
            'recent_ordinances' => array_slice($ordinanceModel->getWithAuthor(), 0, 3),
            'recent_resolutions' => array_slice($resolutionModel->getWithAuthor(), 0, 3),
            'recent_minutes' => array_slice($minuteModel->getPublished(), 0, 3),
            'current_page' => 'home'
        ];
        
        $this->loadView('home/index', $data);
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        $results = [];
        
        if (!empty($query)) {
            $ordinanceModel = new Ordinance();
            $resolutionModel = new Resolution();
            $minuteModel = new Minute();
            $publicationModel = new Publication();
            
            $results = [
                'ordinances' => $ordinanceModel->searchWithAuthor($query),
                'resolutions' => $resolutionModel->searchWithAuthor($query),
                'minutes' => $minuteModel->searchPublished($query),
                'publications' => $publicationModel->searchPublished($query)
            ];
        }
        
        $data = [
            'query' => $query,
            'results' => $results
        ];
        
        $this->loadView('home/search', $data);
    }
}
?>
