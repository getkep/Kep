<?php

    use GetKep\Kep\database\DB;
    use GetKep\Kep\model\BaseModel;

    class myModel extends BaseModel
    {
        public function testing($name)
        {
            $result = DB::select('SELECT * FROM Users WHERE Name = ?', [$name]);

            return $result;
        }
    }
