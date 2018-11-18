<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 11/10/18
 * Time: 3:08 PM
 */

namespace App\System\Repositories;


use App\Occasion;
use App\System\Utilities\CustomLog;
use Exception;

class OccasionRepositoryImpl implements OccasionRepositoryInterface
{
    protected $class = "OccasionRepositoryImpl";
    protected $occasion;

    /**
     * OccasionRepositoryImpl constructor.
     */
    public function __construct()
    {
        $this->occasion = new Occasion();
    }

    public function retrieveAll()
    {
        $method = "retrieveAll";
        try {
            $occasions = $this->occasion->orderBy('created_at', 'desc')->paginate(5);
            return $occasions;
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getMessage());
            return null;
        }


    }

    public function retrieveById(int $id)
    {
        $method = "retrieveById";

        try {
            $occasion = $this->occasion->find($id);
            return $occasion;
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getMessage());
            return null;
        }
    }

    public function save(array $data)
    {
        $method = "save";

        try {
            $this->occasion->title = $data['title'];
            $this->occasion->day = $data['day'];
            $this->occasion->hour = $data['hour'];
            $this->occasion->place = $data['place'];
            $this->occasion->save();
            return $this->occasion;
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getMessage());
            return null;
        }


    }

    public function update(array $data, int $id)
    {
        $method = "update";
        try {
            $occasion = $this->occasion->find($id);
            if ($occasion) {
                $occasion->title = $data['title'];
                $occasion->day = $data['day'];
                $occasion->hour = $data['hour'];
                $occasion->place = $data['place'];
                $occasion->save();
                return $occasion;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, "Internal Server Error: " . $ex->getTrace());
            return null;
        }
    }

    public function delete(int $id)
    {
        $occasion = $this->occasion->find($id);
        if ($occasion) {
            $occasion->delete();
            return true;
        }
        return false;
    }
}
