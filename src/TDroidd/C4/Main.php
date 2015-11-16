<?php
namespace TDroidd\C4;

use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Explosion;
use pocketmine\block\Block;

use pocketmine\event\player\PlayerMoveEvent;

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

    public function onMove(PlayerMoveEvent $event){
        $cfg = $this->getConfig();
        $player = $event->getPlayer();
        $c4 = $block = $player->getLevel()->getBlockIdAt($player->x, ($player->y -0.1), $player->z);
        $e = new Explosion($player, $cfg->get("Explosion-Radius"));
        if($c4 === $cfg->get("C4-Block")){
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