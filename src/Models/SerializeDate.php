<?php

namespace Liushoukun\LaravelProjectTools\Models;

use DateTimeInterface;

trait SerializeDate
{

    /**
     * 为 array / JSON 序列化准备日期格式
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
