<?php
namespace TDroidd\C4;

use pocketmine\command\CommandExecutor;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Explosion;
use pocketmine\block\Block;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->getLogger()->notice(TextFormat::GREEN . "C4 Plugin Enabled");
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveDefaultConfig();

    }


    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        if($command->getName() === "boom") {
            if(count($args)) {
                if(!isset($args[1])) {
                    $sender->sendMessage("Usage: /boom <radius> true|false");
                    return false;
                }
                    if(is_numeric($args[0])) {
                        $sender->sendMessage(TextFormat::YELLOW . "Boom!");
                        $e = new Explosion($sender, $args[0]);
                        switch ($args[1]) {
                            case "true":
                                $e->explodeA();
                                $e->explodeB();
                                break;
                            case "false":
                                $e->explodeB();
                                break;
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Select radius in numeric value!");
                        return;
                    }
            }
        }
    }

        public function onMove(PlayerMoveEvent $event){
        $cfg = $this->getConfig();
        $player = $event->getPlayer();
            $c4 = $event->getPlayer()->getLevel()->getBlock($event->getPlayer()->floor()->subtract(0, 1));
        $e = new Explosion($player, $cfg->get("Explosion-Radius"));
            if($c4->getId() === $cfg->get("C4-Block")) {
            if($cfg->get("Remove-Terrain") == true){
                $player->sendMessage(TextFormat::YELLOW . "[C-4]" . TextFormat::RED . " Booom!!");
                $e->explodeA();
                $e->explodeB();
            }
            else{
                $player->sendMessage(TextFormat::YELLOW . "[C-4]" . TextFormat::RED . " Booom!!");
                $e->explodeB();
            }
        }
    }
}