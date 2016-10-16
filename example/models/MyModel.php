<?php

    use Kep\Database\DB;
    use Kep\Model\BaseModel;

    class MyModel extends BaseModel
    {
        public function testing($name)
        {
            $result = DB::select('SELECT * FROM Users WHERE Name = ?', [$name]);

            return $result;
        }
    }
