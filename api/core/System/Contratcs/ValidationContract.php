<?php

namespace Core\System\Contracts;

interface ValidationContract
{
    public function validate($data, $id = false);
    public function rules($id);
    public function messages();
}