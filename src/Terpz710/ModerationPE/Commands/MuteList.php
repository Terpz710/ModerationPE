<?php

namespace Terpz710\ModerationPE\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Terpz710\ModerationPE\Staff;

class MuteList extends Command
{
    public function __construct()
    {
        parent::__construct(Staff::getInstance()->getConfigValue("mutelist")[0]);
        if (isset(Staff::getInstance()->getConfigValue("mutelist")[1])) $this->setDescription(Staff::getInstance()->getConfigValue("mutelist")[1]);
        $this->setAliases(Staff::getInstance()->getConfigValue("mutelist_aliases"));
        $this->setPermission("moderationpe.mutelist");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!Staff::getInstance()->hasPermissionPlayer($sender, "mutelist")) return;

        $muted = [];
        foreach (Mute::$mute as $name => $value) {
            $muted[] = $name;
        }

        $sender->sendMessage(Staff::getInstance()->getConfigReplace("mutelist_msg", "{mutes}", implode(", ", $muted)));
    }
}