<?php
/**
 * Administration Controller
 * File: modules/Administration/controllers/AdministrationController.php
 * Handles administration business logic
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config/database.php';
require_once dirname(__FILE__) . '/../models/AdministrationModel.php';

class AdministrationController {
    private $db;
    public $administrationModel;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->administrationModel = new AdministrationModel($this->db);
    }

    /**
     * Get all administration data
     * @return array Response array with all administration data
     */
    public function getAllData() {
        try {
            // Get all data
            $leadership = $this->administrationModel->getAllLeadership();
            $staff = $this->administrationModel->getAllStaff();
            $departments = $this->administrationModel->getAllDepartments();
            $orgChart = $this->administrationModel->getOrganizationChart();
            $stats = $this->administrationModel->getStatistics();

            // Format leadership data
            foreach ($leadership as &$leader) {
                $leader = $this->formatLeaderData($leader);
            }

            // Format staff data
            foreach ($staff as &$staffMember) {
                $staffMember = $this->formatStaffData($staffMember);
            }

            // Format departments data
            foreach ($departments as &$department) {
                $department = $this->formatDepartmentData($department);
            }

            // Format organization chart
            if ($orgChart) {
                $orgChart = $this->formatOrgChartData($orgChart);
            }

            return [
                'success' => true,
                'data' => [
                    'leadership' => $leadership,
                    'staff' => $staff,
                    'departments' => $departments,
                    'orgChart' => $orgChart,
                    'statistics' => $stats
                ],
                'counts' => [
                    'leadership' => count($leadership),
                    'staff' => count($staff),
                    'departments' => count($departments)
                ]
            ];

        } catch (Exception $e) {
            error_log("Administration Controller Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve administration information.',
                'error' => $e->getMessage(),
                'data' => [
                    'leadership' => [],
                    'staff' => [],
                    'departments' => [],
                    'orgChart' => null,
                    'statistics' => [
                        'total_staff' => 0,
                        'total_teachers' => 0,
                        'total_departments' => 0,
                        'years_experience' => date('Y') - 2013
                    ]
                ]
            ];
        }
    }

    /**
     * Get administration statistics only
     * @return array Response array with statistics
     */
    public function getStatistics() {
        try {
            $stats = $this->administrationModel->getStatistics();

            return [
                'success' => true,
                'data' => $stats
            ];

        } catch (Exception $e) {
            error_log("Administration Controller Statistics Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve statistics.',
                'error' => $e->getMessage(),
                'data' => [
                    'total_staff' => 0,
                    'total_teachers' => 0,
                    'total_leadership' => 0,
                    'total_departments' => 0,
                    'avg_experience' => 0,
                    'years_experience' => date('Y') - 2013
                ]
            ];
        }
    }

    /**
     * Format leader data
     * @param array $leader Leader data
     * @return array Formatted leader data
     */
    private function formatLeaderData($leader) {
        // Ensure image URL
        if (empty($leader['image_url'])) {
            $leader['image_url'] = 'https://ui-avatars.com/api/?name=' . 
                                   urlencode($leader['full_name']) . 
                                   '&background=0d47a1&color=fff&size=400';
        }

        // Truncate bio if too long
        if (!empty($leader['short_bio']) && strlen($leader['short_bio']) > 100) {
            $leader['short_bio'] = substr($leader['short_bio'], 0, 100) . '...';
        }

        // Format date if exists
        if (isset($leader['created_at'])) {
            $leader['formatted_date'] = date('F j, Y', strtotime($leader['created_at']));
        }

        return $leader;
    }

    /**
     * Format staff data
     * @param array $staff Staff data
     * @return array Formatted staff data
     */
    private function formatStaffData($staff) {
        // Ensure image URL
        if (empty($staff['image_url'])) {
            $staff['image_url'] = 'https://ui-avatars.com/api/?name=' . 
                                  urlencode($staff['full_name']) . 
                                  '&background=0d47a1&color=fff&size=400';
        }

        // Truncate bio if too long
        if (!empty($staff['short_bio']) && strlen($staff['short_bio']) > 100) {
            $staff['short_bio'] = substr($staff['short_bio'], 0, 100) . '...';
        }

        // Format join date
        if (!empty($staff['join_date'])) {
            $staff['formatted_join_date'] = date('M Y', strtotime($staff['join_date']));
        }

        // Get staff type badge class
        $staff['badge_class'] = $this->getStaffBadgeClass($staff['staff_type']);

        return $staff;
    }

    /**
     * Format department data
     * @param array $department Department data
     * @return array Formatted department data
     */
    private function formatDepartmentData($department) {
        // Ensure icon class
        if (empty($department['department_icon'])) {
            $department['department_icon'] = 'fas fa-building';
        }

        // Truncate description if too long
        if (!empty($department['description']) && strlen($department['description']) > 150) {
            $department['description'] = substr($department['description'], 0, 150) . '...';
        }

        return $department;
    }

    /**
     * Format organization chart data
     * @param array $orgChart Organization chart data
     * @return array Formatted organization chart
     */
    private function formatOrgChartData($orgChart) {
        // Ensure image URL
        if (empty($orgChart['image_url'])) {
            $orgChart['image_url'] = '/org-chart.png';
        }

        // Format updated date
        if (isset($orgChart['updated_at'])) {
            $orgChart['formatted_updated_at'] = date('F j, Y', strtotime($orgChart['updated_at']));
        }

        return $orgChart;
    }

    /**
     * Get staff badge CSS class based on staff type
     * @param string $staffType Staff type
     * @return string CSS class
     */
    private function getStaffBadgeClass($staffType) {
        $classes = [
            'teaching' => 'teaching',
            'non_teaching' => 'non_teaching',
            'leadership' => 'leadership'
        ];

        return $classes[$staffType] ?? 'teaching';
    }

    /**
     * Get staff by ID
     * @param int $id Staff ID
     * @return array Response array
     */
    public function getStaffById($id) {
        try {
            if (empty($id)) {
                return [
                    'success' => false,
                    'message' => 'Staff ID is required.'
                ];
            }

            $staff = $this->administrationModel->getStaffById($id);

            if ($staff) {
                $staff = $this->formatStaffData($staff);
                
                return [
                    'success' => true,
                    'data' => $staff
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Staff member not found.'
                ];
            }

        } catch (Exception $e) {
            error_log("Administration Controller Staff Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve staff information.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get department by ID
     * @param int $id Department ID
     * @return array Response array
     */
    public function getDepartmentById($id) {
        try {
            if (empty($id)) {
                return [
                    'success' => false,
                    'message' => 'Department ID is required.'
                ];
            }

            $department = $this->administrationModel->getDepartmentById($id);

            if ($department) {
                $department = $this->formatDepartmentData($department);
                
                return [
                    'success' => true,
                    'data' => $department
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Department not found.'
                ];
            }

        } catch (Exception $e) {
            error_log("Administration Controller Department Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to retrieve department information.',
                'error' => $e->getMessage()
            ];
        }
    }
}
?>