<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

use EA\Application\Services\SendAppointmentLink\SendAppointmentLink;
use \EA\Engine\Types\Text;
use \EA\Engine\Types\Email;
use \EA\Engine\Types\Url;
use EA\Infrastructure\BulkSms\BulkSmsSender as BulkSmsSenderAlias;

/**
 * Appointments Controller
 *
 * @package Controllers
 */
class Appointments extends CI_Controller {
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('installation');

        // Set user's selected language.
        if ($this->session->userdata('language'))
        {
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        }
        else
        {
            $this->lang->load('translations', $this->config->item('language')); // default
        }

        // Common helpers
        $this->load->helper('google_analytics');
    }

    public function send_appointment_link()
    {
        $this->load->model('appointments_model');
        $urlShortener = new BitlyUrlShortener(Config::BITLY_ACCESS_TOKEN);
        $smsSender = new BulkSmsSenderAlias(Config::BULKSMS_TOKEN_CODE);

        $sendAppointmentsLink = new SendAppointmentLink($this->appointments_model, $urlShortener, $smsSender);
        $sendAppointmentsLink->execute();
    }
}
