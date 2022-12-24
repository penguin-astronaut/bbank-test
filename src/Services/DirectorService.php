<?php

namespace App\Services;

use App\Models\Clients\Director;

class DirectorService
{
    public function store($data)
    {
        $director = new Director();
        $director->findByINN($data['inn']);

        if (!$exDirector = $director->findByINN($data['inn'])) {
            $directorId = $director->insert($data);
        } else {
            $directorId = $exDirector['id'];
        }

        return $directorId;
    }
}