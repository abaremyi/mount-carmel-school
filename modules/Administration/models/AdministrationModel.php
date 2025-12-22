<?php
/**
 * Administration Model
 * File: modules/Administration/models/AdministrationModel.php
 * Handles database operations for administration information
 */

class AdministrationModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all leadership team members
     * @return array Array of leadership members
     */
    public function getAllLeadership() {
        try {
            $query = "SELECT 
                        id,
                        full_name,
                        position,
                        role_badge,
                        short_bio,
                        email,
                        phone,
                        image_url,
                        display_order,
                        staff_type,
                        created_at
                      FROM leadership_team 
                      WHERE status = 'active'
                      ORDER BY display_order ASC, full_name ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all staff members
     * @return array Array of staff members
     */
    public function getAllStaff() {
        try {
            $query = "SELECT 
                        s.id,
                        s.staff_code,
                        s.full_name,
                        s.position,
                        s.staff_type,
                        s.department_id,
                        s.qualifications,
                        s.short_bio,
                        s.email,
                        s.phone,
                        s.image_url,
                        s.join_date,
                        s.years_experience,
                        s.display_order,
                        s.status,
                        d.department_name
                      FROM school_staff s
                      LEFT JOIN departments d ON s.department_id = d.id
                      WHERE s.status = 'active'
                      ORDER BY s.display_order ASC, s.full_name ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Staff Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all departments
     * @return array Array of departments
     */
    public function getAllDepartments() {
        try {
            $query = "SELECT 
                        d.id,
                        d.department_name,
                        d.department_icon,
                        d.description,
                        d.staff_count as target_staff,
                        d.email,
                        d.phone,
                        d.head_of_department,
                        d.display_order,
                        d.status,
                        COUNT(s.id) as current_staff
                      FROM departments d
                      LEFT JOIN school_staff s ON d.id = s.department_id AND s.status = 'active'
                      WHERE d.status = 'active'
                      GROUP BY d.id
                      ORDER BY d.display_order ASC, d.department_name ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Departments Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get organization chart
     * @return array|null Organization chart data
     */
    public function getOrganizationChart() {
        try {
            $query = "SELECT 
                        title,
                        description,
                        image_url,
                        updated_at
                      FROM organization_chart 
                      WHERE status = 'active'
                      LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Org Chart Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get administration statistics
     * @return array Statistics data
     */
    public function getStatistics() {
        try {
            $query = "SELECT 
                        (SELECT COUNT(*) FROM school_staff WHERE status = 'active') as total_staff,
                        (SELECT COUNT(*) FROM school_staff WHERE status = 'active' AND staff_type = 'teaching') as total_teachers,
                        (SELECT COUNT(*) FROM school_staff WHERE status = 'active' AND staff_type = 'leadership') as total_leadership,
                        (SELECT COUNT(*) FROM departments WHERE status = 'active') as total_departments,
                        (SELECT AVG(years_experience) FROM school_staff WHERE status = 'active' AND staff_type = 'teaching') as avg_experience";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Calculate years since establishment (2013)
            $currentYear = date('Y');
            $stats['years_experience'] = $currentYear - 2013;
            
            // Ensure numeric values
            $stats['total_staff'] = intval($stats['total_staff']);
            $stats['total_teachers'] = intval($stats['total_teachers']);
            $stats['total_leadership'] = intval($stats['total_leadership']);
            $stats['total_departments'] = intval($stats['total_departments']);
            $stats['avg_experience'] = round(floatval($stats['avg_experience']), 1);
            
            return $stats;
            
        } catch (PDOException $e) {
            error_log("Administration Model Statistics Error: " . $e->getMessage());
            return [
                'total_staff' => 0,
                'total_teachers' => 0,
                'total_leadership' => 0,
                'total_departments' => 0,
                'avg_experience' => 0,
                'years_experience' => date('Y') - 2013
            ];
        }
    }

    /**
     * Get single staff member by ID
     * @param int $id Staff ID
     * @return array|null Staff data
     */
    public function getStaffById($id) {
        try {
            $query = "SELECT 
                        s.*,
                        d.department_name
                      FROM school_staff s
                      LEFT JOIN departments d ON s.department_id = d.id
                      WHERE s.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Get Staff Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get single department by ID
     * @param int $id Department ID
     * @return array|null Department data
     */
    public function getDepartmentById($id) {
        try {
            $query = "SELECT 
                        d.*,
                        COUNT(s.id) as current_staff
                      FROM departments d
                      LEFT JOIN school_staff s ON d.id = s.department_id AND s.status = 'active'
                      WHERE d.id = :id
                      GROUP BY d.id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Administration Model Get Department Error: " . $e->getMessage());
            return null;
        }
    }
}
?>