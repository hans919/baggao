<?php
class CouncilorController extends Controller {
    
    public function index() {
        $councilorModel = new Councilor();
        $councilors = $councilorModel->getActive();
        
        $data = ['councilors' => $councilors];
        $this->loadView('councilors/index', $data);
    }
    
    public function view($id) {
        if (!$id) {
            $this->redirect('councilors');
        }
        
        $councilorModel = new Councilor();
        $councilor = $councilorModel->getWithOrdinanceCount($id);
        
        if (!$councilor) {
            $this->redirect('councilors');
        }
        
        $ordinances = $councilorModel->getOrdinances($id);
        $resolutions = $councilorModel->getResolutions($id);
        
        $data = [
            'councilor' => $councilor,
            'ordinances' => $ordinances,
            'resolutions' => $resolutions
        ];
        
        $this->loadView('councilors/view', $data);
    }
}
?>
