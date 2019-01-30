<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 12/12/2018
 * Time: 6:49 PM
 */

namespace App\Repositories\TB_STATIC;

interface StaticRepository
{
    public function getStaticByCompanyId($company_id);

    public function createStatic($name);

    public function updateStatic($static_id, $name, $company_id);

    public function deleteStatic($static_id, $company_id);

    public function getStaticDashboardById($static_id, $company_id);

    public function updateDashboard(array $attr);

    public function getDatasoureByStaticId($static_id, $company_id);

    public function createDatasource(array $attr);

    public function updateDatasource(array $attr);

    public function deleteDatasourceByStatic($static_id, $id);
}
