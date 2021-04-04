<?php

class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return $this
     */
    private function connect()
    {
        $config = require_once 'config_bd.php';
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['dbName'].';charset='.$config['charset'];
        $this->link = new PDO($dsn, $config['userName'], $config['password']);

        return $this;
    }

    //============================= Select ================================//

    public function SelectServerName($name)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `seerver_naems` WHERE `name` = ?");
        $botUser->execute(array($name));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectUsersGroups($name)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `bot_users` WHERE `group_bot` = ?");
        $botUser->execute(array($name));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function GetBotUsers()
    {
        $permissions = $this->link->query("SELECT * FROM bot_users WHERE `id` = 9");
        while ($permission = $permissions->fetch(PDO::FETCH_ASSOC))
        {
            $allPermissions[] = $permission;
        }
        return $allPermissions;
    }


    public function SelectServerNameId($id)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `seerver_naems` WHERE `id` = ?");
        $botUser->execute(array($id));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddServerName($name)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $botUser =  $this->link->prepare("INSERT INTO `seerver_naems` (`name`) VALUES (?)");
        $botUser->execute(array($name));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerMap($name)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `maps` WHERE `name` = ?");
        $botUser->execute(array($name));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerMapId($id)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `maps` WHERE `id` = ?");
        $botUser->execute(array($id));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddServerMap($maps)
    {
        $botUser =  $this->link->prepare("INSERT INTO `maps` (`name`) VALUES (?)");
        $botUser->execute(array($maps));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectPlayerName($name)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `player_names` WHERE `name` = ?");
        $botUser->execute(array($name));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectPlayerNameId($id)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `player_names` WHERE `id` = ?");
        $botUser->execute(array($id));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddPlayerName($maps)
    {
        $botUser =  $this->link->prepare("INSERT INTO `player_names` (`name`) VALUES (?)");
        $botUser->execute(array($maps));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerInfo($id)
    {
        $serverInfo = $this->link->query("SELECT * FROM server_stats WHERE id_server = $id ORDER BY id DESC LIMIT 1");
        $serverInfo = $serverInfo->fetch(PDO::FETCH_ASSOC);
        $server_name = $this->SelectServerNameId($serverInfo['server_name']);
        $server_map = $this->SelectServerMapId($serverInfo['server_map']);
        $serverInfo['server_name'] = $server_name['name'];
        $serverInfo['server_map'] = $server_map['name'];
        for($j = 1; $j <= 32; $j++)
        {
            if($serverInfo['player_' . $j])
            {
                $player = $this->SelectPlayerNameId($serverInfo['player_' . $j]);
                $serverInfo['player_' . $j] = $player['name'];
            }
        }
        return $serverInfo;
    }

    public function SelectGreeting($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `greeting` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectUser($userId, $chat_id)
    {
        $user = $this->link->prepare("SELECT * FROM `users` WHERE `peer_id` = ? AND `id_chat` = ?");
        $user->execute(array($userId, $chat_id));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectUserName($userName, $chat_id)
    {
        $user = $this->link->prepare("SELECT * FROM `users` WHERE `name` = ? AND `id_chat` = ?");
        $user->execute(array($userName, $chat_id));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectVarnList($chat_id)
    {
        $chatWeekStatsAll = $this->link->query("SELECT * FROM `users` WHERE `varn` > 0 AND `id_chat` = $chat_id");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectUserChatVk($chat_id)
    {
        $chatWeekStatsAll = $this->link->query("SELECT * FROM `users` WHERE  `id_chat` = $chat_id");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectNameUsers($chat_id)
    {
        $nameUsers = $this->link->prepare("SELECT * FROM users WHERE `name` != 'NULL' AND `id_chat` = ?");
        $nameUsers->execute(array($chat_id));
        return $nameUsers;
    }

    public function SearchAdminAccount($login)
    {
        $adminAccount =  $this->link->prepare("SELECT * FROM `admin_account` WHERE `login` = ?");
        $adminAccount->execute(array($login));
        return $adminAccount->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectAllPermission()
    {
        $permissions = $this->link->query("SELECT * FROM permissions");
        while ($permission = $permissions->fetch(PDO::FETCH_ASSOC))
        {
            $allPermissions[] = $permission;
        }
        return $allPermissions;
    }

    public function SelectPermission($permissionId)
    {
        $user = $this->link->prepare("SELECT * FROM `permissions` WHERE `id` = ?");
        $user->execute(array($permissionId));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectMessageDay($userId, $chatId)
    {
        $day = $this->link->prepare("SELECT COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 1 day,'%y%m%d') AND `peer_id` = ? AND `id_chat` = ?");
        $day->execute(array($userId, $chatId));

        return $day->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectMessageWeek($userId, $chatId)
    {
        $week = $this->link->prepare("SELECT COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 7 day,'%y%m%d') AND `peer_id` = ? AND `id_chat` = ?");
        $week->execute(array($userId, $chatId));

        return $week->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectMessageMonth($userId, $chatId)
    {
        $month = $this->link->prepare("SELECT COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND `peer_id` = ? AND `id_chat` = ?");
        $month->execute(array($userId, $chatId));

        return $month->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectMessageYear($userId, $chatId)
    {
        $year = $this->link->prepare("SELECT COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND `peer_id` = ? AND `id_chat` = ?");
        $year->execute(array($userId, $chatId));

        return $year->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectChatMessageDayLine($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `hour`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 1 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `hour` ORDER by `hour`");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageWeekLine($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `date`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 7 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `date` ORDER by `date`");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageMonthLine($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `date`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `date` ORDER by `date`");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageYearLine($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `date`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND `id_chat` = $userId GROUP BY MONTH(`date`) ORDER by MONTH(`date`)");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageDay($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `peer_id`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 1 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `peer_id` ORDER by COUNT(`id`) DESC");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageWeek($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `peer_id`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 7 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `peer_id` ORDER by COUNT(`id`) DESC");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageMonth2($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `peer_id`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `peer_id` ORDER by COUNT(`id`) DESC");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    public function SelectChatMessageYear($userId)
    {
        $chatWeekStatsAll = $this->link->query("SELECT `peer_id`, SUM(chars),COUNT(id) FROM `messages` WHERE `date` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND `id_chat` = $userId GROUP BY `peer_id` ORDER by COUNT(`id`) DESC");
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    //============================ Стата серверов ============================//
    public function SelectServerStatsDay($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT `date_request`, AVG(server_players) FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 0 day,'%y%m%d') AND `id_server` = $server_id GROUP BY HOUR(`date_request`) ORDER by HOUR(`date_request`)");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapDay($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', COUNT(server_stats.id) AS 'COUNT(`id`)' FROM `server_stats` INNER JOIN `maps` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 0 day AND maps.id = `server_map` GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapPlayersDay($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', AVG(`server_players`) FROM `server_stats` INNER JOIN maps WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 0 day AND server_map = maps.id GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsPlayerKillsDay($server_id, $map)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', player_names.name AS 'player_1', `player_kills_1` FROM `server_stats` INNER JOIN maps INNER JOIN player_names WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 0 day,'%y%m%d') AND `id_server` = $server_id AND maps.name ="."'".$map."'"."AND player_names.id = server_stats.player_1 AND maps.id = server_stats.server_map ORDER BY `player_kills_1` DESC LIMIT 1");
        return $serverStatsAll->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerStatsWeek($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT DATE(`date_request`), AVG(server_players) FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 6 day,'%y%m%d') AND `id_server` = $server_id GROUP BY DAY(`date_request`) ORDER by DAY(`date_request`)");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapWeek($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', COUNT(server_stats.id) AS 'COUNT(`id`)' FROM `server_stats` INNER JOIN `maps` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 6 day AND maps.id = `server_map` GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapPlayersWeek($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', AVG(`server_players`) FROM `server_stats` INNER JOIN maps WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 6 day AND server_map = maps.id GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsPlayerKillsWeek($server_id, $map)
    {
        $serverStatsAll = $this->link->query("SELECT maps.name AS 'server_map', player_names.name AS 'player_1', `player_kills_1` FROM `server_stats` INNER JOIN maps INNER JOIN player_names WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 6 day,'%y%m%d') AND `id_server` = $server_id AND maps.name ="."'".$map."'"."AND player_names.id = server_stats.player_1 AND maps.id = server_stats.server_map ORDER BY `player_kills_1` DESC LIMIT 1");
        return $serverStatsAll->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerStatsMonth($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT DATE(`date_request`), AVG(server_players) FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND `id_server` = $server_id GROUP BY DAY(`date_request`) ORDER by DAY(`date_request`)");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapMonth($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, COUNT(`id`) FROM `server_stats` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 30 day GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapPlayersMonth($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, AVG(`server_players`) FROM `server_stats` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 30 day GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsPlayerKillsMonth($server_id, $map)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, `player_1`, `player_kills_1` FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND `id_server` = $server_id AND `server_map` = "."'"."$map"."'"." ORDER BY `player_kills_1` DESC LIMIT 1");
        return $serverStatsAll->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerStatsYear($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT DATE(`date_request`), AVG(server_players) FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND `id_server` = $server_id GROUP BY MONTH(`date_request`) ORDER by MONTH(`date_request`)");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapYear($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, COUNT(`id`) FROM `server_stats` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 365 day GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsMapPlayersYear($server_id)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, AVG(`server_players`) FROM `server_stats` WHERE `id_server` = $server_id AND `date_request` > CURDATE()- INTERVAL 365 day GROUP BY `server_map`");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectServerStatsPlayerKillsYear($server_id, $map)
    {
        $serverStatsAll = $this->link->query("SELECT `server_map`, `player_1`, `player_kills_1` FROM `server_stats` WHERE `date_request` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND `id_server` = $server_id AND `server_map` = "."'"."$map"."'"." ORDER BY `player_kills_1` DESC LIMIT 1");
        return $serverStatsAll->fetch(PDO::FETCH_ASSOC);
    }

    //======================== Статистика команд =============================//


    public function SelectCommandsStatsDay()
    {
        $serverStatsAll = $this->link->query("SELECT commands.name, commands.type, COUNT(command_stats.id_command) FROM `command_stats` INNER JOIN commands WHERE command_stats.`date` > Date_Format(CURDATE()- INTERVAL 1 day,'%y%m%d') AND command_stats.id_command = commands.id GROUP BY command_stats.id_command ORDER BY COUNT(command_stats.id_command) DESC");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectCommandsStatsWeek()
    {
        $serverStatsAll = $this->link->query("SELECT commands.name, commands.type, COUNT(command_stats.id_command) FROM `command_stats` INNER JOIN commands WHERE command_stats.`date` > Date_Format(CURDATE()- INTERVAL 7 day,'%y%m%d') AND command_stats.id_command = commands.id GROUP BY command_stats.id_command ORDER BY COUNT(command_stats.id_command) DESC");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectCommandsStatsMonth()
    {
        $serverStatsAll = $this->link->query("SELECT commands.name, commands.type, COUNT(command_stats.id_command) FROM `command_stats` INNER JOIN commands WHERE command_stats.`date` > Date_Format(CURDATE()- INTERVAL 30 day,'%y%m%d') AND command_stats.id_command = commands.id GROUP BY command_stats.id_command ORDER BY COUNT(command_stats.id_command) DESC");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    public function SelectCommandsStatsYear()
    {
        $serverStatsAll = $this->link->query("SELECT commands.name, commands.type, COUNT(command_stats.id_command) FROM `command_stats` INNER JOIN commands WHERE command_stats.`date` > Date_Format(CURDATE()- INTERVAL 365 day,'%y%m%d') AND command_stats.id_command = commands.id GROUP BY command_stats.id_command ORDER BY COUNT(command_stats.id_command) DESC");
        while ($serverStats = $serverStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $serverStatsReturn[] = $serverStats;
        }
        return $serverStatsReturn;
    }

    //========================================================================//


    public function SelectBotUser($login)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `bot_users` WHERE `login` = ?");
        $botUser->execute(array($login));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectBotUserId($id)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `bot_users` WHERE `id` = ?");
        $botUser->execute(array($id));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectAllBotUser()
    {
        $botUserAll =  $this->link->query("SELECT * FROM `bot_users`");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectUserServers($user_id)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `servers` WHERE  `id_user` = $user_id");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectUserPermissions($id)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `permissions` WHERE  `id_user` = $id");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectPermissions($id)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `permissions` WHERE  `id` = $id");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectDefaultPermissions($user_id)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `default_permission` WHERE  `id_user` = $user_id");
        return $botUserAll->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectServerInformation($id)
    {
        $serverInfo = $this->link->query("SELECT * FROM server_stats WHERE id_server = $id ORDER BY id DESC LIMIT 1");
        $serverInfo = $serverInfo->fetch(PDO::FETCH_ASSOC);
        $server_name = $this->SelectServerNameId($serverInfo['server_name']);
        $server_map = $this->SelectServerMapId($serverInfo['server_map']);
        $serverInfo[0]['server_name'] = $server_name['name'];
        $serverInfo[0]['server_map'] = $server_map['name'];
        $serverInfo[0]['server_players'] = $serverInfo['server_players'];
        $serverInfo[0]['server_max_players'] = $serverInfo['server_max_players'];
        for($j = 1; $j <= 32; $j++)
        {
            if($serverInfo['player_' . $j])
            {
                $player = $this->SelectPlayerNameId($serverInfo['player_' . $j]);
                $serverInfo[0]['player_' . $j] = $player['name'];
            }
        }
        return $serverInfo;
    }

    public function SelectСhatKickUser($chatId)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `users` WHERE  `id_chat` = $chatId AND `chat_kick_user` = 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectBotPermissions($permissionsId)
    {
        $botPermissions =  $this->link->prepare("SELECT * FROM `bot_permissions` WHERE `id` = ?");
        $botPermissions->execute(array($permissionsId));
        return $botPermissions->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectWhere($table, $columnWhere, $valueWhere)
    {
        $select = $this->link->query("SELECT * FROM `{$table}` WHERE {$columnWhere} = {$valueWhere}");
        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectCount($table, $column)
    {
        $count =  $this->link->query("SELECT COUNT(`{$column}`) FROM `{$table}`");
        return $count->fetch(PDO::FETCH_ASSOC);
    }

    public function CheckRole($role, $userId)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `permissions` WHERE `id_user` = ? AND `name` = ?");
        $botUser->execute(array($userId, $role));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }


    //============================= Insert ================================//

    public function Insert($table, $columns, $question,  $values)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $insert = $this->link->prepare("INSERT INTO `$table` ($columns) VALUES ($question)");
        $insert->execute($values);
    }
    public function InsertWhere($table, $column, $columnWhere,  $value, $valueWhere)
    {
        $count = $this->link->prepare("INSERT INTO `{$table}` (`{$column}`) VALUES (?) WHERE {$columnWhere} = {$valueWhere}");
        $count->execute(array($value));
    }
    public function AddUser($userId, $chat_id, $userName, $def)
    {
        $addUser = $this->link->prepare("INSERT INTO `users`(`peer_id`, `id_chat`, `likes`, `nik`, `description`, `varn`, `ban`, `permission`) VALUES (?, ?, 0, ?, '', 0, 0, ?)");
        $addUser->execute(array($userId, $chat_id, $userName, $def));
    }

    public function AddMessage($userId, $chatId, $date, $hour, $chars)
    {
        $addMessage = $this->link->prepare("INSERT INTO `messages`(`peer_id`, `id_chat`, `date`, `hour`, `chars`) VALUES(?, ?, ?, ?, ?)");
        $addMessage->execute(array($userId, $chatId, $date, $hour, $chars));
    }

    public function AddServerStats($columns, $values)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->link->query("INSERT INTO `server_stats`($columns) VALUES($values)");
    }

    public function AddAdminList($userId)
    {
        $addAdmin = $this->link->prepare("INSERT INTO admins (`from_id`) VALUES (?)");
        $addAdmin->execute(array($userId));
    }

    public function AddVipList($userId)
    {
        $addAdmin = $this->link->prepare("INSERT INTO vips (`from_id`) VALUES (?)");
        $addAdmin->execute(array($userId));
    }

    public function AddUserBot($login, $password, $vk_id, $permission)
    {
        $addAdmin = $this->link->prepare("INSERT INTO bot_users (`login`, `vk_id`, `password`, `permission`) VALUES (?, ?, ?, ?)");
        $addAdmin->execute(array($login, $password, $vk_id, $permission));
    }

    public function InsertGreeting($id)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `greeting` (`id_user`, `value`) VALUES (?, ?)");
        $addAdmin->execute(array($id, ''));
    }

    //============================= Update ================================//

    public function UpdateUserName($userId, $userName, $chatId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `name` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($userName, $userId, $chatId));
    }

    public function UpdateUserDescription($userId, $userDescription, $chatId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `description` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($userDescription, $userId, $chatId));
    }

    public function SelectWarns($chatId, $userId)
    {
        $addUser = $this->link->prepare("SELECT COUNT(`id`) FROM `warn_list` WHERE `peer_id` = ? AND `chat_id` = ?");
        $addUser->execute(array($userId, $chatId));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectPromoCode($promoCode)
    {
        $addUser = $this->link->prepare("SELECT * FROM `promo_code` WHERE `code` = ?");
        $addUser->execute(array($promoCode));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectActivePromoCode($userId, $codeId)
    {
        $addUser = $this->link->prepare("SELECT * FROM `use_promo_code` WHERE `id_user` = ? AND `id_promo_code` = ?");
        $addUser->execute(array($userId, $codeId));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddActivePromoCode($userId, $codeId)
    {
        $addUser = $this->link->prepare("INSERT INTO `use_promo_code` (`id_user`, `id_promo_code`) VALUES(?, ?)");
        $addUser->execute(array($userId, $codeId));
    }

    public function SelectWarnListGroup($chatId)
    {
        $botUserAll = $this->link->query("SELECT * FROM `warn_list` WHERE `chat_id` = $chatId GROUP BY `peer_id`");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectWarnList($chatId, $userId)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `warn_list` WHERE  `chat_id` = $chatId AND `peer_id` = $userId");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function UpdateUserVarn($userId, $userVarn, $chatId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `varn` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($userVarn, $userId, $chatId));
    }

    public function UpdateUserMute($userId, $userMute, $chatId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `mute` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($userMute, $userId, $chatId));
    }

    public function AddWarn($chatId, $userId, $comment)
    {
        $addUser = $this->link->prepare("INSERT INTO `warn_list`(`peer_id`, `chat_id`, `comment`) VALUES (?, ?, ?)");
        $addUser->execute(array($userId, $chatId, $comment));
    }

    public function DeleteWarn($chatId, $userId)
    {
        $addUser = $this->link->prepare("DELETE FROM `warn_list` WHERE `peer_id` = ? AND `chat_id` = ?");
        $addUser->execute(array($userId, $chatId));
    }

    public function DeleteAllWarn($chatId)
    {
        $addUser = $this->link->prepare("DELETE FROM `warn_list` WHERE `chat_id` = ?");
        $addUser->execute(array($chatId));
    }


    public function UpdateUserLikes($userId, $userLikes, $chatId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `likes` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($userLikes, $userId, $chatId));
    }

    public function UpdatePermission($chatId, $userId, $roleId)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `permission` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($roleId, $userId, $chatId));
    }

    public function UpdateServer($link, $type, $count, $top, $skill, $kills, $death, $head, $server, $map, $players, $players_kills, $players_time, $change_map, $mvp_map, $map_night, $map_2x2mod, $change_map_talk, $status, $say, $id)
    {
        $addUser = $this->link->prepare("UPDATE `servers` SET `link` = ?, `type` = ?, `count` = ?, `top` = ?, `skill` = ?, `kills` = ?, `death` = ?, `head` = ?, `map` = ?, `server` = ?, `players` = ?, `players_kills` = ?, `players_time` = ?, `change_map` = ?, `mvp_map` = ?, `map_night` = ?, `map_2x2mod` = ?, `change_map_talk` = ?, `status` = ?, `say` = ? WHERE `id` = ?");
        $addUser->execute(array($link, $type, $count, $top, $skill, $kills, $death, $head, $map, $server, $players, $players_kills, $players_time, $change_map, $mvp_map, $map_night, $map_2x2mod, $change_map_talk, $status, $say, $id));
    }

    public function UpdateLiteServer($server, $map, $players, $id)
    {
        $addUser = $this->link->prepare("UPDATE `servers` SET  `map` = ?, `server` = ?, `players` = ? WHERE `id` = ?");
        $addUser->execute(array($map, $server, $players, $id));
    }

    public function UpdatePermissions($id, $name, $bans, $profiles, $interactive, $server)
    {
        $addUser = $this->link->prepare("UPDATE `permissions` SET `name` = ?, `bans` = ?, `profiles` = ?, `interactive` = ?, `server` = ? WHERE `id` = ?");
        $addUser->execute(array($name, $bans, $profiles, $interactive, $server, $id));
    }

    public function UpdatedefaultPermission($id, $idUser)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("UPDATE `default_permission` SET `id_permission` = ? WHERE `id_user` = ?");
        $addUser->execute(array($id, $idUser));
    }

    public function UpdatedeСhatKickUser($chatId ,$idUser)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `chat_kick_user` = ? WHERE `id_chat` = ? AND `peer_id` = ?");
        $addUser->execute(array(1, $chatId, $idUser, ));
    }

    public function UpdateGreeting($id, $value)
    {
        $addUser = $this->link->prepare("UPDATE `greeting` SET `value` = ? WHERE `id_user` = ?");
        $addUser->execute(array($value, $id));
    }

    //============================= Delete ================================//

    public function DeleteUser($userId, $chatId)
    {
        $addAdmin = $this->link->prepare("DELETE FROM `users` WHERE `id` = ? AND `id_chat` = ?");
        $addAdmin->execute(array($userId, $chatId));
    }

    public function DeleteVipList($userId)
    {
        $addAdmin = $this->link->prepare("DELETE FROM vips WHERE from_id = ?");
        $addAdmin->execute(array($userId));
    }

    //============================= Other =====================================//

    public function AutoAdd()
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user =  $this->link->query("SELECT * FROM `bot_users` ORDER BY `id` DESC LIMIT 1");
        $user = $user->fetch(PDO::FETCH_ASSOC);


        $addPermission_admin = $this->link->prepare("INSERT INTO `permissions` (`id_user`, `name`, `bans`, `profiles`, `interactive`, `server`) VALUES (?,?,?,?,?,?)");
        $addPermission_admin->execute(array($user['id'], 'администратор', 1, 0, 1, 1));
        $addPermission_owner = $this->link->prepare("INSERT INTO `permissions` (`id_user`, `name`, `bans`, `profiles`, `interactive`, `server`) VALUES (?,?,?,?,?,?)");
        $addPermission_owner->execute(array($user['id'], 'главный администратор', 1, 1, 1, 1));
        $addPermission_mut = $this->link->prepare("INSERT INTO `permissions` (`id_user`, `name`, `bans`, `profiles`, `interactive`, `server`) VALUES (?,?,?,?,?,?)");
        $addPermission_mut->execute(array($user['id'], 'мут бота', 0, 0, 0, 0));
        $addPermission_user = $this->link->prepare("INSERT INTO `permissions` (`id_user`, `name`, `bans`, `profiles`, `interactive`, `server`) VALUES (?,?,?,?,?,?)");
        $addPermission_user->execute(array($user['id'], 'участник', 0, 0, 1, 1));

        $id_permission =  $this->link->query("SELECT * FROM `permissions` ORDER BY `id` DESC LIMIT 1");
        $id_permission = $id_permission->fetch(PDO::FETCH_ASSOC);


        $addPermission_user = $this->link->prepare("INSERT INTO `default_permission` (`id_user`, `id_permission`) VALUES (?,?)");
        $addPermission_user->execute(array($user['id'], $id_permission['id']));

        // Приветствие
        $greeting = $this->link->prepare("INSERT INTO `greeting` (`id_user`, `value`) VALUES (?, ?)");
        $greeting->execute(array($user['id'], ''));
    }

    // топ игроков
    public function SelectTop($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `top_players` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }
    public function InsertTop($id)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `top_players` (`id_user`, `link`, `type`, `count`, `top`, `skill`, `kills`, `death`, `head`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($id, '', '', 15, 'топ 15', 1, 1, 1, 0));
    }
    public function UpdateTop($id, $link, $type, $count, $top, $skill, $kills, $death, $head)
    {
        $addUser = $this->link->prepare("UPDATE `top_players` SET `link` = ?, `type` = ?, `count` = ?, `top` = ?, `skill` = ?, `kills` = ?, `death` = ?, `head` = ? WHERE `id_user` = ?");
        $addUser->execute(array($link, $type, $count, $top, $skill, $kills, $death, $head, $id));
    }

    // интерактив
    public function SelectInteractive($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `interactive` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }
    public function InsertInteractive($id)
    {
        $addAdmin = $this->link->query("INSERT INTO
 `interactive` (`id_user`, `off_add_groups`, `varn_mat`, `on_greeting`, `count_varn`, `who`, `info`, `horoscope`, `wether`, `holidays`, `online_vk`, `tranlite`, `ban`, `varn`, `actions`, `mute`, `csgo`, `wall_repost_admin`, `wall_repost_user`, `topic_repost`,  `server`, `players`, `map`, `servers`, `top_server`, `who_profile`, `top_chat`, `nicknames`, `commends`, `change_nick`, `change_description`, `change_rating` ,`role`,`kick_dogs`,`check_subscribe`) 
VALUES ($id, 0, 0, 1, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1 ,1 ,1 ,1, 1, 1, 1)");
    }
    public function UpdateInteractive($id, $off_add_groups, $varn_mat, $on_greeting, $count_varn, $check_group, $wall_repost_admin, $wall_repost_user, $topic_repost, $ban_ip)
    {
        $addUser = $this->link->prepare("UPDATE `interactive` SET `off_add_groups` = ?, `varn_mat` = ?, `on_greeting` = ?, `count_varn` = ?, `check_group` = ?, `wall_repost_admin` = ?, `wall_repost_user` = ?, `topic_repost` = ?, `ban_ip` = ? WHERE `id_user` = ?");
        $addUser->execute(array($off_add_groups, $varn_mat, $on_greeting, $count_varn, $check_group, $wall_repost_admin, $wall_repost_user, $topic_repost, $ban_ip, $id));
    }

    public function UpdateStateCommends($id, $who, $info, $horoscope, $wether, $holidays, $online_vk, $tranlite, $ban, $varn, $actions, $mute, $csgo, $server, $players, $map, $servers, $top_server, $who_profile, $top_chat, $nicknames, $commends, $change_nick, $change_description, $change_rating, $role, $kick_dogs, $check_subscribe, $marriages)
    {
        $addUser = $this->link->prepare("UPDATE `interactive` SET `who` = ?, `info` = ?, `horoscope` = ?, `wether` = ?, `holidays` = ?, `online_vk` = ?, `tranlite` = ?,
 `ban` = ?, `varn` = ?, `actions` = ?, `mute` = ?, `csgo` = ?, `server` = ?, `players` = ?, `map` = ?, 
  `servers` = ?, `top_server` = ?, `who_profile` = ?, `top_chat` = ?, `nicknames` = ?, `commends` = ?, `change_nick` = ?, `change_description` = ?,
   `change_rating` = ?,`role` = ?,`kick_dogs` = ?,`check_subscribe` = ?, `marriages` = ? WHERE `id_user` = ?");
        $addUser->execute(array($who, $info, $horoscope, $wether, $holidays, $online_vk, $tranlite, $ban, $varn, $actions, $mute, $csgo, $server, $players,
            $map, $servers, $top_server, $who_profile, $top_chat, $nicknames, $commends, $change_nick, $change_description, $change_rating, $role, $kick_dogs, $check_subscribe, $marriages, $id));
    }

    // Новости
    public function InsertNews($text, $img, $date)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `news` (`text`, `img`, `date`) VALUES (?, ?, ?)");
        $addAdmin->execute(array($text, $img, $date));
    }

    public function SelectNewsSite()
    {
        $botUserAll =  $this->link->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectNews()
    {
        $botUserAll = $this->link->query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function Change_map($id_server)
    {
        $botUserAll = $this->link->query("SELECT `id`, `server_name`, `server_map`, `date_request` FROM `server_stats` WHERE `id_server` = $id_server ORDER BY `id` DESC LIMIT 2");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    // Пользовательские команды
    public function SelectUserCommand($id_user)
    {
        $botUserAll = $this->link->query("SELECT * FROM `user_commands` WHERE `user_id` = $id_user");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function UpdateUserCommand($id, $command, $value)
    {
        $addUser = $this->link->prepare("UPDATE `user_commands` SET `command` = ?, `value` = ? WHERE `id` = ?");
        $addUser->execute(array($command, $value, $id));
    }

    public function DeleteUserCommand($id)
    {
        $addUser = $this->link->prepare("DELETE FROM `user_commands` WHERE `id` = ?");
        $addUser->execute(array($id));
    }

    public function AddUserCommand($user_id, $command, $value)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("INSERT INTO `user_commands` (`user_id`, `command`, `value`) VALUES (?, ?, ?)");
        $addUser->execute(array($user_id, $command, $value));
    }

    public function SelectUserCommandTime($id_user)
    {
        $botUserAll = $this->link->query("SELECT * FROM `user_commands_time` WHERE `user_id` = $id_user");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }


    public function UpdateUserCommandTime($id, $comment, $time, $value)
    {
        $addUser = $this->link->prepare("UPDATE `user_commands_time` SET `comment` = ?, `time` = ?, `value` = ? WHERE `id` = ?");
        $addUser->execute(array($comment, $time, $value, $id));
    }

    public function DeleteUserCommandTime($id)
    {
        $addUser = $this->link->prepare("DELETE FROM `user_commands_time` WHERE `id` = ?");
        $addUser->execute(array($id));
    }

    public function AddUserCommandTime($user_id, $comment, $time, $value)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("INSERT INTO `user_commands_time` (`user_id`, `comment`, `time`, `value`) VALUES (?, ?, ?, ?)");
        $addUser->execute(array($user_id, $comment, $time, $value));
    }

    public function SelectUserCommandChance($id_user)
    {
        $botUserAll = $this->link->query("SELECT * FROM `user_commands_chance` WHERE `user_id` = $id_user");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }


    public function UpdateUserCommandChance($id, $comment, $chance, $value, $type)
    {
        $addUser = $this->link->prepare("UPDATE `user_commands_chance` SET `comment` = ?, `chance` = ?, `value` = ?, `type` = ? WHERE `id` = ?");
        $addUser->execute(array($comment, $chance, $value, $type, $id));
    }

    public function UpdateUserCommandLine($line, $id)
    {
        $addUser = $this->link->prepare("UPDATE `user_commands_chance` SET `line` = ? WHERE `id` = ?");
        $addUser->execute(array($line, $id));
    }

    public function DeleteUserCommandChance($id)
    {
        $addUser = $this->link->prepare("DELETE FROM `user_commands_chance` WHERE `id` = ?");
        $addUser->execute(array($id));
    }

    public function AddUserCommandChance($user_id, $comment, $chance, $value, $type)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("INSERT INTO `user_commands_chance` (`user_id`, `comment`, `chance`, `value`, `type`) VALUES (?, ?, ?, ?, ?)");
        $addUser->execute(array($user_id, $comment, $chance, $value, $type));
    }

    public function UpdateUserChatVk($id, $chatId, $name, $description, $permission)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `name` = ?, `description` = ?, `permission` = ? WHERE `id` = ? AND `id_chat` = ?");
        $addUser->execute(array($name, $description, $permission, $id, $chatId));
    }

    public function DeleteAllVarns($id)
    {
        $addUser = $this->link->prepare("UPDATE `users` SET `varn` = 0 WHERE `id_chat` = ? AND `varn` > 0");
        $addUser->execute(array($id));
    }

    public function UpdateAllUsers($id, $chatId, $lastName, $photo)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("UPDATE `users` SET `last_name` = ?, `photo50` = ? WHERE `peer_id` = ? AND `id_chat` = ?");
        $addUser->execute(array($lastName, $photo, $id, $chatId));
    }

    public function AddCommandStats($chatId, $commandId, $time)
    {
        $addMessage = $this->link->prepare("INSERT INTO `command_stats`(`id_user`, `id_command`, `date`) VALUES(?, ?, ?)");
        $addMessage->execute(array($chatId, $commandId, $time));
    }

    public function AddApiKey($id_user, $api_key, $date, $server_info, $vk_info, $messages_info, $send_messages)
    {
        $addUser = $this->link->prepare("INSERT INTO `api_keys`(`id_user`, `api_key`, `date`, `server_info`, `vk_info`, `messages_info`, `send_messages`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $addUser->execute(array($id_user, $api_key, $date, $server_info, $vk_info, $messages_info, $send_messages));
    }

    public function SelectApiKey($id_user)
    {
        $botUserAll = $this->link->query("SELECT `api_key`, `date`, `server_info`, `vk_info`, `messages_info`, `send_messages` FROM `api_keys` WHERE `id_user` = " . $id_user);
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectUserApiKey($apiKey)
    {
        $addUser = $this->link->prepare("SELECT bot_users.id AS 'id', bot_users.login as 'login', api_keys.server_info AS 'server_info', api_keys.vk_info AS 'vk_info', api_keys.messages_info AS 'messages_info', api_keys.send_messages FROM api_keys INNER JOIN bot_users WHERE api_keys.api_key = ? AND `id_user` = bot_users.id");
        $addUser->execute(array($apiKey));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectAddApiKey($apiKey)
    {
        $addUser = $this->link->prepare("SELECT id FROM `bot_users` WHERE `api_key` = ?");
        $addUser->execute(array($apiKey));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectOwnerInfoAPI($apiKey)
    {
        $addUser = $this->link->prepare("SELECT vk_id, date_rental, group_bot FROM `bot_users` WHERE `api_key` = ?");
        $addUser->execute(array($apiKey));
        return $addUser->fetch(PDO::FETCH_ASSOC);
    }

    public function UpdateBotUser($date_rental, $group_bot, $discount, $id)
    {
        $addUser = $this->link->prepare("UPDATE `bot_users` SET `date_rental` = ?, `group_bot` = ?, `discount` = ? WHERE `id` = ?");
        $addUser->execute(array($date_rental, $group_bot, $discount, $id));
    }

    public function UpdateBotUserVkInfo($firstName, $lastName, $photo50, $id)
    {
        $addUser = $this->link->prepare("UPDATE `bot_users` SET `first_name` = ?, `last_name` = ?, `photo50` = ? WHERE `id` = ?");
        $addUser->execute(array($firstName, $lastName, $photo50, $id));
    }

    public function UpdateBotUserVkInfoGroup($name, $photo, $id)
    {
        $addUser = $this->link->prepare("UPDATE `bot_users` SET `group_name` = ?, `group_photo50` = ? WHERE `id` = ?");
        $addUser->execute(array($name, $photo, $id));
    }

    // Оповещения мониторингов
    public function SelectAllAlertTg()
    {
        $botUserAll = $this->link->query("SELECT * FROM `alert_monitorings` WHERE `alert_tg` = 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }
    public function SelectAlertMonitoring($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `alert_monitorings` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }
    public function InsertAlertMonitorings($id)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `alert_monitorings` (`id_user`, `alert_day`, `alert_week`, `alert_vk`, `alert_tg`, `24boostru`, `serverovnet`, `cs-msru`, `cs-boosterru`, `mega-boostru`, `turbo-boostru`, `listcsru`, `monitoring.fungunnet`, `fine-boostru`, `leo-boostru`, `cs-serversnet`, `cs-strikenet`, `ezboostru`, `topmsru`, `csadminru`, `esmsru`, `litemonitoringru`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($id, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1));
    }
    public function UpdateAlertMonitorings($id, $alert_day, $alert_week, $alert_vk, $alert_tg, $_24boostru, $serverovnet, $cs_msru, $cs_boosterru, $mega_boostru, $turbo_boostru, $listcsru, $monitoring_fungunnet, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru, $topmsru, $csadminru, $esmsru, $litemonitoringru)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("UPDATE `alert_monitorings` SET `alert_day` = ?, `alert_week` = ?, `alert_vk` = ?, `alert_tg` = ?, `24boostru` = ?, `serverovnet` = ?, `cs-msru` = ?, `cs-boosterru` = ?, `mega-boostru` = ?, `turbo-boostru` = ?, `listcsru` = ?, `monitoring.fungunnet` = ?, `fine-boostru` = ?, `leo-boostru` = ?, `cs-serversnet` = ?, `cs-strikenet` = ?, `ezboostru` = ?, `topmsru` = ?, `csadminru` = ?, `esmsru` = ?, `litemonitoringru` = ? WHERE `id_user` = ?");
        $addUser->execute(array($alert_day, $alert_week, $alert_vk, $alert_tg, $_24boostru, $serverovnet, $cs_msru, $cs_boosterru, $mega_boostru, $turbo_boostru, $listcsru, $monitoring_fungunnet, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru, $topmsru, $csadminru, $esmsru, $litemonitoringru, $id));
    }

    // оповещение об приближении улсуг
    public function SelectAlertNearestPlaceVk()
    {
        $botUserAll = $this->link->query("SELECT * FROM `alert_nearest_place` WHERE `alert_vk` = 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }
    public function SelectAlertNearestPlaceTg()
    {
        $botUserAll = $this->link->query("SELECT * FROM `alert_nearest_place` WHERE `alert_tg` = 1");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }
    public function SelectAlertNearestPlace($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `alert_nearest_place` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }
    public function InsertAlertNearestPlace($id)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `alert_nearest_place` (`id_user`, `alert_day`, `alert_week`, `alert_vk`, `alert_tg`, `24boostru`, `serverovnet`, `cs-boosterru`, `mega-boostru`, `turbo-boostru`, `fine-boostru`, `leo-boostru`, `cs-serversnet`, `cs-strikenet`, `ezboostru`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($id, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1));
    }
    public function UpdateAlertNearestPlace($id, $alert_day, $alert_week, $alert_vk, $alert_tg, $_24boostru, $serverovnet, $cs_boosterru, $mega_boostru, $turbo_boostru, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru)
    {
        $addUser = $this->link->prepare("UPDATE `alert_nearest_place` SET `alert_day` = ?, `alert_week` = ?, `alert_vk` = ?, `alert_tg` = ?, `24boostru` = ?, `serverovnet` = ?, `cs-boosterru` = ?, `mega-boostru` = ?, `turbo-boostru` = ?, `fine-boostru` = ?, `leo-boostru` = ?, `cs-serversnet` = ?, `cs-strikenet` = ?, `ezboostru` = ? WHERE `id_user` = ?");
        $addUser->execute(array($alert_day, $alert_week, $alert_vk, $alert_tg, $_24boostru, $serverovnet, $cs_boosterru, $mega_boostru, $turbo_boostru, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru, $id));
    }

    // Страница мониторингов
    public function SelectLikeMonitoring($id)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `likes_monitorings` WHERE `id_user` = ?");
        $selectGreeting->execute(array($id));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }
    public function InsertLikeMonitorings($id)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `likes_monitorings` (`id_user`, `public_info`, `note`, `24boostru`, `serverovnet`, `cs-msru`, `cs-boosterru`, `mega-boostru`, `turbo-boostru`, `listcsru`, `monitoring.fungunnet`, `fine-boostru`, `leo-boostru`, `cs-serversnet`, `cs-strikenet`, `ezboostru`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($id, 1, '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1));
    }
    public function UpdateLikeMonitorings($id, $public_info, $note, $_24boostru, $serverovnet, $cs_msru, $cs_boosterru, $mega_boostru, $turbo_boostru, $listcsru, $monitoring_fungunnet, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru)
    {
        $addUser = $this->link->prepare("UPDATE `likes_monitorings` SET `public_info` = ?, `note` = ?, `24boostru` = ?, `serverovnet` = ?, `cs-msru` = ?, `cs-boosterru` = ?, `mega-boostru` = ?, `turbo-boostru` = ?, `listcsru` = ?, `monitoring.fungunnet` = ?, `fine-boostru` = ?, `leo-boostru` = ?, `cs-serversnet` = ?, `cs-strikenet` = ?, `ezboostru` = ? WHERE `id_user` = ?");
        $addUser->execute(array($public_info, $note, $_24boostru, $serverovnet, $cs_msru, $cs_boosterru, $mega_boostru, $turbo_boostru, $listcsru, $monitoring_fungunnet, $fine_boostru, $leo_boostru, $cs_serversnet, $cs_strikenet, $ezboostru, $id));
    }

    public function SelectLastBotUser()
    {
        $botUserAll = $this->link->query("SELECT * FROM `bot_users` ORDER BY `id` DESC LIMIT 1");
        return $botUserAll->fetch(PDO::FETCH_ASSOC);
    }

    public function UpdateUserRental($id, $days)
    {
        $addAdmin = $this->link->prepare("UPDATE `bot_users` SET `date_rental` = ?  WHERE `id` = ?");
        $addAdmin->execute(array($days, $id));
    }

    public function SelectUserUserTalk($id)
    {
        $addAdmin = $this->link->prepare("SELECT * FROM `user_talks` WHERE `id` = ?");
        $addAdmin->execute(array($id));
        return $addAdmin->fetch(PDO::FETCH_ASSOC);
    }

    // Беседы
    public function SelectUserUserTalks($id_user)
    {
        $botUserAll = $this->link->query("SELECT * FROM `user_talks` WHERE `user_id` = $id_user");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function UpdateUserUserTalks($id, $peer_id, $comment)
    {
        $addUser = $this->link->prepare("UPDATE `user_talks` SET `peer_id` = ?, `comment` = ? WHERE `id` = ?");
        $addUser->execute(array($peer_id, $comment, $id));
    }

    public function DeleteUserUserTalks($id)
    {
        $addUser = $this->link->prepare("DELETE FROM `user_talks` WHERE `id` = ?");
        $addUser->execute(array($id));
    }

    public function AddUserUserTalks($user_id, $peer_id, $comment)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("INSERT INTO `user_talks` (`user_id`, `peer_id`, `comment`) VALUES (?, ?, ?)");
        $addUser->execute(array($user_id, $peer_id, $comment));
    }

    // Беседы
    public function SelectUserUserTopics($id_user)
    {
        $botUserAll = $this->link->query("SELECT * FROM `user_topics` WHERE `id_user` = $id_user");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function UpdateUserUserTopics($id, $link_topic, $comment, $type)
    {
        $addUser = $this->link->prepare("UPDATE `user_topics` SET `link` = ?, `comment` = ?, `type` = ? WHERE `id` = ?");
        $addUser->execute(array($link_topic, $comment, $type, $id));
    }

    public function DeleteUserUserTopics($id)
    {
        $addUser = $this->link->prepare("DELETE FROM `user_topics` WHERE `id` = ?");
        $addUser->execute(array($id));
    }

    public function AddUserUserTopics($id_user, $link, $link_topic, $type)
    {
        $addUser = $this->link->prepare("INSERT INTO `user_topics` (`id_user`, `link`, `comment`, `type`) VALUES (?, ?, ?, ?)");
        $addUser->execute(array($id_user, $link, $link_topic, $type));
    }

    public function AddGlobalBanList($idUser, $firstName, $lastName, $photo50, $peerId, $comment, $dateAddet)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `global_banlist` (`id_user`, `first_name`, `last_name`, `photo50`, `peer_id`, `comment`, `date_addet`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($idUser, $firstName, $lastName, $photo50, $peerId, $comment, $dateAddet));
    }

    public function SelectGlobalBanList($peer_id)
    {
        $botUserAll =  $this->link->query("SELECT bot_users.group_bot, bot_users.group_photo50 AS 'bot_users.group_photo50', bot_users.group_name, global_banlist.`first_name`, global_banlist.`last_name`, global_banlist.`photo50`, global_banlist.`peer_id`, global_banlist.`comment`, global_banlist.`date_addet` FROM `global_banlist` INNER JOIN bot_users WHERE `id_user` = bot_users.id AND global_banlist.`peer_id` = " . $peer_id);
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function SelectUserGlobalBanList($user_id)
    {
        $botUserAll =  $this->link->query("SELECT bot_users.group_bot, bot_users.group_photo50 AS 'bot_users.group_photo50', bot_users.group_name, global_banlist.`first_name`, global_banlist.`last_name`, global_banlist.`photo50`, global_banlist.`peer_id`, global_banlist.`comment`, global_banlist.`date_addet` FROM `global_banlist` INNER JOIN bot_users WHERE `id_user` = bot_users.id AND `id_user` = " . $user_id . " ORDER BY global_banlist.`date_addet` DESC LIMIT 100");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function AddBanIp($ip, $comment, $dateAddet)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `ban_ip` (`ip`, `comment`, `date_addet`) VALUES (?, ?, ?)");
        $addAdmin->execute(array($ip, $comment, $dateAddet));
    }

    public function SelectBanIp($ip)
    {
        $botUserAll = $this->link->query("SELECT * FROM `ban_ip` where `ip` = " . "'" . $ip . "'" . " ORDER BY `date_addet` DESC LIMIT 1");
        return $botUserAll->fetch(PDO::FETCH_ASSOC);
    }

    public function AddRequestMarriages($chatId, $fromId, $fwdFromId)
    {
        $addAdmin = $this->link->prepare("UPDATE `users` SET `marriage_request` = ? WHERE `id_chat` = ? AND `peer_id` = ?");
        $addAdmin->execute(array($fromId, $chatId, $fwdFromId));
    }

    public function AddMarriages($chatId, $fromId, $fwdFromId, $first_name1, $first_name2, $date)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `marriages` (`partner_1`, `partner_2`, `date`, `first_name1`, `first_name2`, `chat_id`) VALUES(?, ?, ?, ?, ?, ?)");
        $addAdmin->execute(array($fromId, $fwdFromId, $date, $first_name1, $first_name2, $chatId));
    }

    public function SelectMarriages($idUser, $chatId)
    {
        $selectGreeting = $this->link->prepare("SELECT * FROM `marriages` WHERE `partner_1` = ? or `partner_2` = ? AND `chat_id` = ?");
        $selectGreeting->execute(array($idUser, $idUser, $chatId));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectAllMarriages($chatId)
    {
        $botUserAll =  $this->link->query("SELECT * FROM `marriages` WHERE `chat_id` = " . $chatId);
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function DeleteMarriages($idUser, $chatId)
    {
        $selectGreeting = $this->link->prepare("DELETE FROM `marriages` WHERE `partner_1` = ? or `partner_2` = ? AND `chat_id` = ?");
        $selectGreeting->execute(array($idUser, $idUser, $chatId));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }

    public function SelectRequestMarriages($idUser, $chatId)
    {
        $selectGreeting = $this->link->prepare("SELECT `marriage_request` FROM `users` WHERE `id` = ? AND `id_chat` = ?");
        $selectGreeting->execute(array($idUser, $chatId));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }

    public function AddTextMessages($chatId, $userId, $text, $date, $platform)
    {
        $addAdmin = $this->link->prepare("INSERT INTO `text_messages` (`chat_id`, `id_user`, `text`, `date`, `platform`) VALUES(?, ?, ?, ?, ?)");
        $addAdmin->execute(array($chatId, $userId, $text, $date, $platform));
    }

    public function DeleteTextMessages($chatId)
    {
        $selectGreeting = $this->link->prepare("DELETE FROM `text_messages` WHERE `chat_id` = ?");
        $selectGreeting->execute(array($chatId));
        return $selectGreeting->fetch(PDO::FETCH_ASSOC);
    }


    public function SelectTextMessages($chatId)
    {
        $botUserAll =  $this->link->query("SELECT users.nik AS 'firstName', users.peer_id AS 'peerId', users.photo50 AS 'photo50', `text` AS 'message', `platform`, `date` FROM `text_messages` INNER JOIN `users` WHERE `chat_id` = $chatId AND `id_user` = users.peer_id AND users.id_chat = $chatId");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

}
