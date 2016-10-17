<?php

namespace Lencse\Date;


class DateFormatter
{

    /**
     * @param \DateTime $date
     * @return string
     */
    public function prettyDate(\DateTime $date)
    {
        return sprintf(
            '%s. %s %s.',
            $date->format('Y'),
            $this->getMonthName($date->format('m')),
            $date->format('d')
        );
    }

    /**
     * @param $month int
     * @return string
     */
    private function getMonthName($month)
    {
        return [
            'január',
            'február',
            'március',
            'április',
            'május',
            'június',
            'július',
            'augusztus',
            'szeptember',
            'október',
            'november',
            'december',
        ][$month - 1];
    }
    
}