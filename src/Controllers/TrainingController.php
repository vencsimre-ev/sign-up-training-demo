<?php

namespace src\Controllers;

use Exception;
use src\Services\GoogleSheetsService;
use src\Services\ScheduleService;
use src\Models\Attendee;

class TrainingController
{
    private $googleSheetsService;
    private $scheduleService;

    public function __construct()
    {
        $this->googleSheetsService = new GoogleSheetsService();
        $this->scheduleService = new ScheduleService();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!$this->scheduleService->isRegistrationOpen()) {
                    throw new Exception('A regisztráció jelenleg nem elérhető.');
                }

                $name = $_POST['name'] ?? '';
                $attendee = new Attendee($name);
                $this->googleSheetsService->saveAttendee($attendee);
            } catch (Exception $e) {
                // Általános hiba kezelése és visszajelzés
                echo json_encode(['status' => 'error', 'message' => 'Váratlan hiba történt: ' . $e->getMessage()]);
            }
        } else {
            if ($this->scheduleService->isRegistrationOpen()) {
                include 'templates/register_form.php';
            } else {
                $sessions = $this->scheduleService->getUpcomingSessions();
                include 'templates/registration_closed.php';
            }
        }
    }
}
