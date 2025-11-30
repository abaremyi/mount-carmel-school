<?php
/**
 * Gallery Controller
 * File: modules/Gallery/controllers/GalleryController.php
 * Handles gallery business logic
 */

// Fix the database path - go up 3 levels to reach the root, then to config
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config/database.php';
require_once dirname(__FILE__) . '/../models/GalleryModel.php';

class GalleryController {
    private $db;
    public $galleryModel;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->galleryModel = new GalleryModel($this->db);
    }

    /**
     * Get gallery images with pagination
     * @param array $params Parameters: limit, offset, category
     * @return array Response array with success, data, and metadata
     */
    public function getGalleryImages($params = []) {
        try {
            $limit = isset($params['limit']) ? (int)$params['limit'] : 10;
            $offset = isset($params['offset']) ? (int)$params['offset'] : 0;
            $category = isset($params['category']) ? $params['category'] : null;

            // Validate limit (max 100)
            if ($limit > 100) {
                $limit = 100;
            }

            // Get images
            $images = $this->galleryModel->getGalleryImages($limit, $offset, $category);

            // Get total count
            $total = $this->galleryModel->getTotalCount($category);

            return [
                'success' => true,
                'data' => $images,
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset,
                'category' => $category
            ];

        } catch (Exception $e) {
            error_log("Gallery Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve gallery images.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get gallery categories
     * @return array Response array with success and categories
     */
    public function getCategories() {
        try {
            $categories = $this->galleryModel->getCategories();

            return [
                'success' => true,
                'data' => $categories
            ];

        } catch (Exception $e) {
            error_log("Gallery Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve categories.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get single gallery image
     * @param int $id Image ID
     * @return array Response array
     */
    public function getImageById($id) {
        try {
            if (empty($id)) {
                return [
                    'success' => false,
                    'message' => 'Image ID is required.'
                ];
            }

            $image = $this->galleryModel->getImageById($id);

            if ($image) {
                return [
                    'success' => true,
                    'data' => $image
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Image not found.'
                ];
            }

        } catch (Exception $e) {
            error_log("Gallery Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve image.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get next and previous image IDs for navigation
     * @param int $currentId Current image ID
     * @param string $category Optional category filter
     * @return array Next and previous IDs
     */
    public function getNavigationIds($currentId, $category = null) {
        try {
            // Get all images in order
            $images = $this->galleryModel->getGalleryImages(1000, 0, $category);
            
            $navigation = [
                'prev' => null,
                'next' => null
            ];
            
            $currentIndex = -1;
            foreach ($images as $index => $image) {
                if ($image['id'] == $currentId) {
                    $currentIndex = $index;
                    break;
                }
            }
            
            if ($currentIndex !== -1) {
                // Previous image
                if ($currentIndex > 0) {
                    $navigation['prev'] = $images[$currentIndex - 1]['id'];
                }
                
                // Next image
                if ($currentIndex < count($images) - 1) {
                    $navigation['next'] = $images[$currentIndex + 1]['id'];
                }
            }
            
            return [
                'success' => true,
                'data' => $navigation
            ];
            
        } catch (Exception $e) {
            error_log("Gallery Controller Navigation Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to get navigation data.',
                'error' => $e->getMessage()
            ];
        }
    }
}
?>