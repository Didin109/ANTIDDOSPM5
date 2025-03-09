<?php

declare(strict_types=1);

namespace Terra\AntiDDOS;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerPreLoginEvent;

class AntiDDOS extends PluginBase implements Listener {

    private array $connections = [];

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("[AntiDDOS] Plugin aktif!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("[AntiDDOS] Plugin dinonaktifkan.");
    }

    public function onPlayerPreLogin(PlayerPreLoginEvent $event): void {
        $ip = $event->getIp();
        $this->connections[$ip] = ($this->connections[$ip] ?? 0) + 1;

        if ($this->connections[$ip] > 3) { // Batasi 3 koneksi per IP
            $event->setKickMessage("Terlalu banyak koneksi dari IP ini!");
            $event->cancel();
        }
    }
}
