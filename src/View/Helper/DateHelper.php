<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

class DateHelper extends Helper
{
    public function format($date, $showTime = false)
    {
        if (!$date) {
            return '<span class="sin-datos">Sin datos</span>';
        }
        
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        
        $format = $showTime ? 'd/m/Y H:i' : 'd/m/Y';
        return $date->format($format);
    }
    
    public function formatOrEmpty($date, $showTime = false)
    {
        if (!$date) {
            return '<span class="sin-datos">Sin datos</span>';
        }
        return $this->format($date, $showTime);
    }
}