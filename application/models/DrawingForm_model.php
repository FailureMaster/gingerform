<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DrawingForm_model extends CI_Model {

    public function saveSubmission($name, $email, $drawingFilePath)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'drawing' => $drawingFilePath,
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('submission', $data);
    }
}
