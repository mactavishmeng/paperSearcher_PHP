<?php


namespace App\Controllers;


class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function search($keyword)
    {
        $model = model(PaperModel::class);
        $request = \Config\Services::request();
        $limit = (int)$request->getGet()['limit'];
        $offset = (int)$request->getGet()['offset'];
        if ($keyword == "") return;
        if ($limit == "") $limit = 10;
        if ($offset == "") $offset = 0;
        $data = $model->search($keyword, $limit, $offset);
        echo json_encode($data);
    }

    public function abstract($id)
    {
        $model = model(PaperModel::class);
        $data = $model->abstract($id);
        echo json_encode(["code"=>0, "data" => $data]);
    }

}