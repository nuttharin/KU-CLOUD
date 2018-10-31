<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 6:01 PM
 */

namespace App\LogViewer;


class Level
{
    private $levels_classes = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'warning' => 'warning',
        'error' => 'danger',
        'critical' => 'danger',
        'alert' => 'danger',
        'emergency' => 'danger',
        'processed' => 'info',
        'failed' => 'warning',
    ];

    private $levels_imgs = [
        'debug' => 'fa fa-fw fa-life-ring',
        'info' => 'fa fa-fw fa-info-circle',
        'notice' => 'fa fa-fw fa-exclamation-circle',
        'warning' => 'fa fa-fw fa-exclamation-triangle',
        'error' => 'fa fa-fw fa-times-circle',
        'critical' => 'fa fa-fw fa-heartbeat',
        'alert' => 'fa fa-fw fa-bullhorn',
        'emergency' => 'fa fa-fw fa-bug',
        'processed' => 'info-circle',
        'failed' => 'exclamation-triangle'
    ];

    private  $levels_color = [
        'debug'     => '#90CAF9',
        'info'      => '#1976D2',
        'notice'    => '#4CAF50',
        'warning'   => '#FF9100',
        'error'     => '#FF5722',
        'critical'  => '#F44336',
        'alert'     => '#D32F2F',
        'emergency' => '#B71C1C',
        'empty'     => '#D1D1D1',
        'all'       => '#8A8A8A',
    ];

    public function all()
    {
        return array_keys($this->levels_imgs);
    }

    public function img($level)
    {
        return $this->levels_imgs[$level];
    }

    public  function color($level){
        return $this->levels_color[$level];
    }

    public function cssClass($level)
    {
        return $this->levels_classes[$level];
    }
}