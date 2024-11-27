<?php

namespace src\Services;

use Exception;
use Google\Client;
use Google\Service\Sheets;
use src\Models\Attendee;
use Dotenv\Dotenv;

class GoogleSheetsService
{
    private $service;
    private $spreadsheetId;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        if (!$dotenv->load()) {
            throw new Exception('.env fájl nem található vagy nem tölthető be!');
        }

        $this->spreadsheetId = $_ENV['SPREADSHEET_ID'];

        $client = new Client();
        $client->setAuthConfig($_ENV['GOOGLE_AUTH_CONFIG_PATH']);
        $client->addScope(Sheets::SPREADSHEETS);
        $this->service = new Sheets($client);
    }

    public function saveAttendee(Attendee $attendee): void
    {
        try {
            $values = [[$attendee->getDate(), $attendee->getName()]];
            $body = new Sheets\ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            $this->service->spreadsheets_values->append($this->spreadsheetId, 'november!A1:B1', $body, $params);

            echo json_encode(['status' => 'success', 'message' => 'Köszi! Sikeresen elmentve!']);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Hiba az adat küldése közben: ' . $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Váratlan hiba történt: ' . $e->getMessage()]);
        }
    }
}
