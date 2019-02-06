<?php

namespace App\Repositories\TB_DATA_ANALYSIS;

interface DataAnalysisRepository
{
    public function getAll();

	public function getById($data_id);

	public function create(array $attr);

	public function delete($data_id,$user_id);
}
