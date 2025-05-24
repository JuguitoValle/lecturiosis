<?php
namespace App\Interfaces;

interface ModelInterface
{
    public function save();
    public function delete();
    public function findById($id);
    public static function get();
}