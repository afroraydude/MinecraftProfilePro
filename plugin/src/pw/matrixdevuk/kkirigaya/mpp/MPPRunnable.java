package pw.matrixdevuk.kkirigaya.mpp;

import org.bukkit.scheduler.BukkitRunnable;
import static pw.matrixdevuk.kkirigaya.mpp.Main.*;

public class MPPRunnable extends BukkitRunnable {

    @Override
    public void run() {
        player.add(is_banned);
        player.add(jumps);
        player.add(is_operator);
        player.add(name);
        player.add(uuid);
        player.add(sword_swings);
        player.add(player_kills);
        player.add(mob_kills);
        player.add(last_gamemode);
        /* TODO: Push everything to the SQL server */
    }

}
