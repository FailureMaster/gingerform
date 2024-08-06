<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DrawingForm extends CI_Controller {

    public function index()
    {
        $this->load->view('drawing_form');
    }

    public function submit()
    {
        // Load necessary libraries and helpers
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->model('DrawingForm_model');

        // Get form data
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $drawingDataURL = $this->input->post('drawing');

        // Save the drawing as an image file
        $drawingData = explode(',', $drawingDataURL)[1];
        $drawingData = base64_decode($drawingData);
        $drawingDirectory = FCPATH . 'application/uploads/drawings/';
        $drawingFilePath = $drawingDirectory . uniqid() . '.png';

        // Ensure the directory exists
        if (!is_dir($drawingDirectory)) {
            mkdir($drawingDirectory, 0755, true);
        }

        file_put_contents($drawingFilePath, $drawingData);

        // Configure email
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'sandbox.smtp.mailtrap.io',
            'smtp_port' => 2525,
            'smtp_user' => '0506c63daaffc5',
            'smtp_pass' => '9cb7a9cbede061',
            'crlf' => "\r\n",
            'newline' => "\r\n"
          );
        // Initialize email library with the configuration
        $this->email->initialize($config);

        // Send emails
        $this->email->from('mike.macabulos@gmail.com', 'Your Name');
        $this->email->to($email); 
        $this->email->subject('Form Submission');
        $this->email->message("Thank you, $name, for your submission. See the drawing attached.");
        $this->email->attach($drawingFilePath);

        if (!$this->email->send()) {
            echo $this->email->print_debugger();
            log_message('error', 'Email not sent: ' . $this->email->print_debugger());
        } else {
            log_message('info', 'Email sent successfully to ' . $email);
        }

        // Save data to the database
        if (!$this->DrawingForm_model->saveSubmission($name, $email, $drawingFilePath)) {
            log_message('error', 'Database error: Could not save submission');
        } else {
            log_message('info', 'Submission saved to database');
        }

        echo json_encode(['status' => 'success']);
    }

    
}
