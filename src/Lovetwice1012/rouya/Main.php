<?php

namespace Lovetwice1012\rouya;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener{

	
	public $myConfig;
		       
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
       
		$this->myConfig = new Config($this->getDataFolder() . "MyConfig.yml", Config::YAML);

	}

	public function onJoin(PlayerJoinEvent $event){
		$config = $this->myConfig;
		$pos = new Vector3(256, 4, 263);
  $player = $event->getPlayer();
  /** @var Config $config */
  if($config->exists($player->getName())&&$config->get($player->getName())==true){
	$player->setImmobile();
	 $player->teleport($pos);
  }		
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
	{
		$config = $this->myConfig;
        if ($label === "rouya") {
            if ($sender->isOp()) {
		    
		if(isset($args[0])){
			$player = $this->getServer()->getPlayer($args[0]);
		if($config->get($player->getName())==false){
			$pos = new Vector3(256, 4, 263);
			
$player->setImmobile();
	 $player->teleport($pos);
		    $config->set($player->getName(),true);
		    $config->save();
		    
	    	    $sender->sendMessage("牢屋にぶち込みました。");
		}else{
			$player = $this->getServer()->getPlayer($args[0]);
			$pos = new Vector3(255, 4, 255);
		$config->set($player->getName(),false);
			$player->setImmobile(false);
	 $player->teleport($pos);
		    $config->save();	
			$sender->sendMessage("牢屋から出しました。");
		}
		}else{
	
		    $sender->sendMessage("§c使用方法:/rouya ぶち込み・出したい人の名前");
			}
		
            }else{
	        $sender->sendMessage("§c権限がありません");
	    }
	
        }
        return true;
    }

}
