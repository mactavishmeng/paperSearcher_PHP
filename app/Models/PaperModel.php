<?php

namespace App\Models;

use CodeIgniter\Model;

class PaperModel extends Model
{
    protected $table = 'paper';

    public function search($keyword = "", $limit = 10, $offset = 0)
    {
        $flag = 0;
        $prev_symbol = "";
        while ($keyword != trim($keyword, "|+ "))
        {
            $keyword = trim($keyword, "|+ ");
        }
        $keyword .= "|";
        for ($i = 0; $i < strlen($keyword); $i++)
        {
            if ($keyword[$i] == "|" | $keyword[$i] == "+")
            {
                $kw = trim(substr($keyword, $flag, $i - $flag));
                if ($prev_symbol == "|")
                {
//                    echo "OR", $kw;
                    $this->orLike('title', $kw);
                    $this->orLike('abstract', $kw);
                } else {
//                    echo $kw;
                    $this->Like('title', $kw);
                    $this->orLike('abstract', $kw);
                }
                $prev_symbol = $keyword[$i];
                $flag = $i + 1;
            }
        }
//        return $this->orWhere(['id' => $keyword])->first();
        $counts = $this->orderBy('year', 'desc')->countAllResults(false);
        return ["code" => 0,
            "rows" => $this->orderBy('year', 'desc')->findAll($limit, $offset),
            "total" => $counts];
    }

    public function abstract($id = 0)
    {
        return $this->select('title, abstract')->where('id', $id)->first();
    }
}