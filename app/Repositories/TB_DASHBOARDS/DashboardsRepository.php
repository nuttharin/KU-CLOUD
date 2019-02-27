<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 12/12/2018
 * Time: 6:49 PM
 */

namespace App\Repositories\TB_DASHBOARDS;

interface DashboardsRepository
{
    public function getAllDashboard();

    public function getDashboardById($dashboard_id);

    public function createDashboard($name);

    public function updateDashboardLayout($dashboard_id, $layout);

    public function updateDashboard($dashboard_id, $name);

    public function deleteDashboard($dashboard_id);

}
