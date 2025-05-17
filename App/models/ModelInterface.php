<?php
// App/models/ModelInterface.php

interface ModelInterface {
    public function save();
    public function delete();
    public function findById($id);
}