<?php 
namespace src\Services;

use DateTime;
use DateTimeZone;
use Exception;

class ScheduleService
{
    private $timeZone;
    private $sessions;

    private $dayTranslations = [
        'Monday'    => 'Hétfő',
        'Tuesday'   => 'Kedd',
        'Wednesday' => 'Szerda',
        'Thursday'  => 'Csütörtök',
        'Friday'    => 'Péntek',
        'Saturday'  => 'Szombat',
        'Sunday'    => 'Vasárnap',
    ];

    public function __construct(string $configPath = 'resources/schedule.json')
    {
        if (!file_exists($configPath)) {
            throw new Exception('A konfigurációs fájl nem található: ' . $configPath);
        }

        $config = json_decode(file_get_contents($configPath), true);

        if (isset($config['timezone'])) {
            $this->timeZone = new DateTimeZone($config['timezone']);
        } else {
            $this->timeZone = new DateTimeZone('UTC'); // Alapértelmezett időzóna
        }

        $this->sessions = $config['sessions'] ?? [];

        // $this->sessions = [];
        // foreach ($config['sessions'] as $day => $times) {
        //     $translatedDay = $this->dayTranslations[$day] ?? $day; // Fordítás alkalmazása
        //     $this->sessions[$translatedDay] = $times;
        // }
    }

    public function isRegistrationOpen(): bool
    {
        $now = new DateTime('now', $this->timeZone);
        $currentDay = $now->format('l');
        $currentTime = $now->format('H:i');

        if (!isset($this->sessions[$currentDay])) {
            return false;
        }

        foreach ($this->sessions[$currentDay] as [$start, $end]) {
            $startMinusOneHour = (new DateTime($start, $this->timeZone))->modify('-1 hour');
            $endTime = new DateTime($end, $this->timeZone);

            if ($now >= $startMinusOneHour && $now <= $endTime) {
                return true;
            }
        }

        return false;
    }

    public function getUpcomingSessions(): array
    {
        // days translation
        if($this->sessions){
            foreach ($this->sessions as $day => $times) {
                $translatedDay = $this->dayTranslations[$day] ?? $day; // Fordítás alkalmazása
                $this->sessions[$translatedDay] = $times;
                unset($this->sessions[$day]);
            }        
        }
        return $this->sessions;
    }
}
