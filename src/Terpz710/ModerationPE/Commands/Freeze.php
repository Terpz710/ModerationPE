<?php

namespace Terpz710\ModerationPE\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\entity\Entity;
use pocketmine\Server;

use Terpz710\ModerationPE\Staff;

class Freeze extends Command
{
    public function __construct()
    {
        parent::__construct(Staff::getInstance()->getConfigValue("freeze")[0]);
        if (isset(Staff::getInstance()->getConfigValue("freeze")[1])) $this->setDescription(Staff::getInstance()->getConfigValue("freeze")[1]);
        $this->setAliases(Staff::getInstance()->getConfigValue("freeze_aliases"));
        $this->setPermission("moderationpe.freeze");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!Staff::getInstance()->hasPermissionPlayer($sender, "freeze")) return;

        if (isset($args[0])) {
            $entity = Server::getInstance()->getPlayerByPrefix($args[0]);
            if ($entity instanceof Entity) {
                if (!$entity->hasNoClientPredictions()) {
                    $entity->setNoClientPredictions();
                    $entity->sendMessage(Staff::getInstance()->getConfigReplace("freeze_sender", "{player}", $player->getName()));
                    $entity->sendMessage(Staff::getInstance()->getConfigReplace("freeze_player", "{player}", $sender->getName()));
                    Staff::getInstance()->sendDiscordMessage($player, $sender, null, "freeze_discord");
                } else $sender->sendMessage(Staff::getInstance()->getConfigReplace("freeze_freeze"));
            } else $sender->sendMessage(Staff::getInstance()->getConfigReplace("no_online_player"));
        } else $sender->sendMessage(Staff::getInstance()->getConfigReplace("no_args_player"));
    }
}
