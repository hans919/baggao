<?php
class CouncilorController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $councilorModel = new Councilor();
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if (!empty($search)) {
            $councilors = $councilorModel->search($search, ['name', 'position', 'committees']);
        } elseif (!empty($status)) {
            $councilors = $councilorModel->getByStatus($status);
        } else {
            $councilors = $councilorModel->getActive();
        }
        
        // Get councilor statistics for each councilor
        foreach ($councilors as &$councilor) {
            $councilor['ordinance_count'] = $councilorModel->getOrdinanceCount($councilor['id']);
            $councilor['resolution_count'] = $councilorModel->getResolutionCount($councilor['id']);
        }
        
        $data = [
            'councilors' => $councilors,
            'current_search' => $search,
            'current_status' => $status,
            'current_page' => 'councilors'
        ];
        
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
    
    // Admin CRUD Methods
    public function admin_index() {
        $this->requireAuth();
        
        $councilorModel = new Councilor();
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if (!empty($search)) {
            $councilors = $councilorModel->search($search, ['name', 'position', 'committees']);
        } elseif (!empty($status)) {
            $councilors = $councilorModel->getByStatus($status);
        } else {
            $councilors = $councilorModel->findAll();
        }
        
        // Add statistics to each councilor
        foreach ($councilors as &$councilor) {
            $councilor['ordinance_count'] = $councilorModel->getOrdinanceCount($councilor['id']);
            $councilor['resolution_count'] = $councilorModel->getResolutionCount($councilor['id']);
        }
        
        $data = [
            'councilors' => $councilors,
            'current_search' => $search,
            'current_status' => $status
        ];
        
        $this->loadAdminView('admin/councilors', $data);
    }
    
    public function admin_add() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $councilorModel = new Councilor();
            
            $data = [
                'name' => $_POST['name'],
                'position' => $_POST['position'],
                'term_start' => $_POST['term_start'],
                'term_end' => $_POST['term_end'],
                'committees' => $_POST['committees'],
                'contact_info' => $_POST['contact_info'],
                'email' => $_POST['email'] ?? null,
                'bio' => $_POST['bio'] ?? null,
                'education' => $_POST['education'] ?? null,
                'achievements' => $_POST['achievements'] ?? null,
                'social_facebook' => $_POST['social_facebook'] ?? null,
                'social_twitter' => $_POST['social_twitter'] ?? null,
                'district' => $_POST['district'] ?? null,
                'status' => $_POST['status']
            ];
            
            // Handle photo upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photo_path = $this->uploadPhoto($_FILES['photo']);
                if ($photo_path) {
                    $data['photo'] = $photo_path;
                }
            }
            
            if ($councilorModel->create($data)) {
                $_SESSION['success'] = 'Councilor added successfully';
            } else {
                $_SESSION['error'] = 'Failed to add councilor';
            }
            
            $this->redirect('admin/councilors');
        }
        
        $this->loadAdminView('admin/add_councilor');
    }
    
    public function admin_edit($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $this->redirect('admin/councilors');
        }
        
        $councilorModel = new Councilor();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'position' => $_POST['position'],
                'term_start' => $_POST['term_start'],
                'term_end' => $_POST['term_end'],
                'committees' => $_POST['committees'],
                'contact_info' => $_POST['contact_info'],
                'email' => $_POST['email'] ?? null,
                'bio' => $_POST['bio'] ?? null,
                'education' => $_POST['education'] ?? null,
                'achievements' => $_POST['achievements'] ?? null,
                'social_facebook' => $_POST['social_facebook'] ?? null,
                'social_twitter' => $_POST['social_twitter'] ?? null,
                'district' => $_POST['district'] ?? null,
                'status' => $_POST['status']
            ];
            
            // Handle photo upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Get current councilor to delete old photo
                $current_councilor = $councilorModel->findById($id);
                
                $photo_path = $this->uploadPhoto($_FILES['photo']);
                if ($photo_path) {
                    $data['photo'] = $photo_path;
                    
                    // Delete old photo if it exists
                    if ($current_councilor && !empty($current_councilor['photo'])) {
                        $this->deletePhoto($current_councilor['photo']);
                    }
                }
            }
            
            if ($councilorModel->update($id, $data)) {
                $_SESSION['success'] = 'Councilor updated successfully';
            } else {
                $_SESSION['error'] = 'Failed to update councilor';
            }
            
            $this->redirect('admin/councilors');
        }
        
        $councilor = $councilorModel->findById($id);
        if (!$councilor) {
            $this->redirect('admin/councilors');
        }
        
        $data = ['councilor' => $councilor];
        $this->loadAdminView('admin/edit_councilor', $data);
    }
    
    public function admin_delete($id = null) {
        $this->requireAuth();
        
        if (!$id) {
            $this->redirect('admin/councilors');
        }
        
        $councilorModel = new Councilor();
        $councilor = $councilorModel->findById($id);
        
        if (!$councilor) {
            $_SESSION['error'] = 'Councilor not found';
            $this->redirect('admin/councilors');
        }
        
        // Check if councilor has authored ordinances or resolutions
        $ordinance_count = $councilorModel->getOrdinanceCount($id);
        $resolution_count = $councilorModel->getResolutionCount($id);
        
        if ($ordinance_count > 0 || $resolution_count > 0) {
            $_SESSION['error'] = 'Cannot delete councilor who has authored ordinances or resolutions. Set status to inactive instead.';
            $this->redirect('admin/councilors');
        }
        
        // Delete photo if exists
        if (!empty($councilor['photo'])) {
            $this->deletePhoto($councilor['photo']);
        }
        
        if ($councilorModel->delete($id)) {
            $_SESSION['success'] = 'Councilor deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete councilor';
        }
        
        $this->redirect('admin/councilors');
    }
    
    private function uploadPhoto($file) {
        // Construct absolute upload directory path
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mom/' . UPLOAD_PATH . 'councilors/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                $_SESSION['error'] = 'Failed to create upload directory.';
                return false;
            }
        }
        
        // Validate and sanitize the file
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $original_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        // Check file extension
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, GIF, and WebP images are allowed.';
            return false;
        }
        
        // Check file size (5MB limit for images)
        if ($file['size'] > 5 * 1024 * 1024) {
            $_SESSION['error'] = 'File size too large. Maximum size is 5MB.';
            return false;
        }
        
        // Generate safe filename
        $safe_filename = preg_replace('/[^a-z0-9-_]/', '-', strtolower($original_name));
        $file_name = $safe_filename . '_' . uniqid() . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;
        
        // Verify MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        $allowed_mimes = [
            'image/jpeg' => ['jpg', 'jpeg'],
            'image/png' => ['png'],
            'image/gif' => ['gif'],
            'image/webp' => ['webp']
        ];
        
        $mime_valid = false;
        foreach ($allowed_mimes as $mime => $extensions) {
            if ($mime_type === $mime && in_array($file_extension, $extensions)) {
                $mime_valid = true;
                break;
            }
        }
        
        if (!$mime_valid) {
            $_SESSION['error'] = 'Invalid file type detected.';
            return false;
        }
        
        // Move the file
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Set proper file permissions
            chmod($file_path, 0644);
            
            // Optionally resize image to standard size
            $this->resizeImage($file_path, 400, 400);
            
            // Return relative path for database storage
            return 'councilors/' . $file_name;
        }
        
        $_SESSION['error'] = 'Failed to upload photo. Please try again.';
        return false;
    }
    
    private function deletePhoto($photo_path) {
        if (empty($photo_path)) return;
        
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/mom/' . UPLOAD_PATH . $photo_path;
        if (file_exists($full_path)) {
            unlink($full_path);
        }
    }
    
    private function resizeImage($file_path, $max_width, $max_height) {
        // Get image info
        $image_info = getimagesize($file_path);
        if (!$image_info) return false;
        
        $width = $image_info[0];
        $height = $image_info[1];
        $mime_type = $image_info['mime'];
        
        // Check if resize is needed
        if ($width <= $max_width && $height <= $max_height) {
            return true; // No resize needed
        }
        
        // Calculate new dimensions
        $ratio = min($max_width / $width, $max_height / $height);
        $new_width = round($width * $ratio);
        $new_height = round($height * $ratio);
        
        // Create image resource based on type
        switch ($mime_type) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($file_path);
                break;
            case 'image/png':
                $source = imagecreatefrompng($file_path);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($file_path);
                break;
            case 'image/webp':
                $source = imagecreatefromwebp($file_path);
                break;
            default:
                return false;
        }
        
        if (!$source) return false;
        
        // Create new image
        $new_image = imagecreatetruecolor($new_width, $new_height);
        
        // Handle transparency for PNG and GIF
        if ($mime_type === 'image/png' || $mime_type === 'image/gif') {
            imagecolortransparent($new_image, imagecolorallocatealpha($new_image, 0, 0, 0, 127));
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }
        
        // Resize image
        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save resized image
        switch ($mime_type) {
            case 'image/jpeg':
                imagejpeg($new_image, $file_path, 85);
                break;
            case 'image/png':
                imagepng($new_image, $file_path, 6);
                break;
            case 'image/gif':
                imagegif($new_image, $file_path);
                break;
            case 'image/webp':
                imagewebp($new_image, $file_path, 85);
                break;
        }
        
        // Clean up memory
        imagedestroy($source);
        imagedestroy($new_image);
        
        return true;
    }
}
?>
