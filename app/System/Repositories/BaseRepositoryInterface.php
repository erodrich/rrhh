<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 9:19 AM
 */

namespace App\System\Repositories;


interface BaseRepositoryInterface
{
    public function retrieveAll();
    public function retrieveById(int $id);
    public function save(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
}