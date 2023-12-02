<?php

namespace Terpz710\ModerationPE\Events;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;

use Terpz710\ModerationPE\Commands\Mute;
use Terpz710\ModerationPE\Task\BanTask;
use Terpz710\ModerationPE\Staff;

class StaffEvents implements Listener
{
    public function onJoin(PlayerJoinEvent $event)
    {
        if (Staff::getInstance()->isBannedPlayer($event->getPlayer())) new BanTask($event->getPlayer());
    }

    public function onChat(PlayerChatEvent $event)
    {
        if (!empty(Mute::$mute[$event->getPlayer()->getName()]) and Mute::$mute[$event->getPlayer()->getName()] > time()) {
            $time = Mute::$mute[$event->getPlayer()->getName()];
            $day = Staff::getInstance()->getRemainingTime($time, "day");
            $hour = Staff::getInstance()->getRemainingTime($time, "hour");
            $min = Staff::getInstance()->getRemainingTime($time, "minute");
            $second = Staff::getInstance()->getRemainingTime($time, "second");
            $event->getPlayer()->sendMessage(Staff::getInstance()->getConfigReplace("no_chat", ["{day}", "{hour}", "{minute}", "{second}"], [$day, $hour, $min, $second]));
            $event->cancel();
        }
    }
}