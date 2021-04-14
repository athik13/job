<?php


namespace App\Helpers\Search\Traits\Filters;

trait SalaryFilter
{
    protected function applySalaryFilter()
    {
        if (!isset($this->having)) {
            return;
        }

        $minSalary = null;
        if (request()->filled('minSalary')) {
            $minSalary = request()->get('minSalary');
        }

        $maxSalary = null;
        if (request()->filled('maxSalary')) {
            $maxSalary = request()->get('maxSalary');
        }

        if (!empty($minSalary)) {
            $this->having[] = 'salary_min >= ' . $minSalary;
        }

        if (!empty($maxSalary)) {
            $this->having[] = 'salary_max <= ' . $maxSalary;
        }
    }
}
