<?php
/**
 * Gallery Model
 * File: modules/Gallery/models/GalleryModel.php
 * Handles all database operations for gallery
 */

class GalleryModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get gallery images with pagination
     * @param int $limit Number of images to retrieve
     * @param int $offset Starting position
     * @param string $category Optional category filter
     * @return array Array of gallery images
     */
    public function getGalleryImages($limit = 10, $offset = 0, $category = null) {
        try {
            $whereClause = "WHERE status = 'active'";
            
            if ($category) {
                $whereClause .= " AND category = :category";
            }
            
            $query = "SELECT 
                        id,
                        title,
                        description,
                        image_url,
                        thumbnail_url,
                        category,
                        display_order,
                        created_at
                      FROM gallery_images 
                      $whereClause
                      ORDER BY display_order ASC, created_at DESC 
                      LIMIT :limit OFFSET :offset";
            
            $stmt = $this->db->prepare($query);
            
            if ($category) {
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            }
            
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Gallery Model Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of gallery images
     * @param string $category Optional category filter
     * @return int Total count
     */
    public function getTotalCount($category = null) {
        try {
            $whereClause = "WHERE status = 'active'";
            
            if ($category) {
                $whereClause .= " AND category = :category";
            }
            
            $query = "SELECT COUNT(*) as total FROM gallery_images $whereClause";
            $stmt = $this->db->prepare($query);
            
            if ($category) {
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)$result['total'];
            
        } catch (PDOException $e) {
            error_log("Gallery Model Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get gallery categories
     * @return array Array of categories
     */
    public function getCategories() {
        try {
            $query = "SELECT DISTINCT category 
                      FROM gallery_images 
                      WHERE status = 'active' 
                      ORDER BY category ASC";
            
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
            
        } catch (PDOException $e) {
            error_log("Gallery Model Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single gallery image by ID
     * @param int $id Image ID
     * @return array|null Image data or null
     */
    public function getImageById($id) {
        try {
            $query = "SELECT * FROM gallery_images WHERE id = :id AND status = 'active'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Gallery Model Error: " . $e->getMessage());
            return null;
        }
    }
}
?>
