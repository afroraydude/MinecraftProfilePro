package pw.matrixdevuk.mcpp;

import org.bukkit.scheduler.BukkitRunnable;
import static pw.matrixdevuk.mcpp.Main.*;

public class MPPRunnable extends BukkitRunnable {

    /*
    protected static List<Object>   player          = new ArrayList<>();
    protected static UUID           uuid            = UUID.fromString("");
    protected static String         name            = "";
    protected static Integer        sword_swings    = 0;
    protected static Integer        player_kills    = 0;
    protected static Integer        mob_kills       = 0;
    protected static Integer        last_gamemode   = 0;
    protected static Integer        jumps           = 0;
    protected static Integer        deaths          = 0;
    protected static Integer        diamonds_found  = 0;
    protected static Integer        enchantments    = 0;
    protected static Integer        blocks_placed   = 0;
    protected static Integer        blocks_broken   = 0;
    protected static Boolean        is_operator     = false;
    protected static Boolean        is_banned       = false;
     */

    @Override
    public void run() {
        // Get all the stats and add them to the query

        /* TODO: Push everything to the SQL server */
        String query = "";
        // the following goes in a for loop of ALL the player objects
            query += "UPDATE `players` SET ";
            query += "`name`='" + name + "' ";
            query += "`sword_swings`=`sword_swings`+" + sword_swings + " ";
            query += "`player_kills`=`player_kills`+";
            query += "WHERE `uuid`=" + uuid;
            query += ";"; // semi-colon to begin the next player's section of the query

        // Set values back to zero after the push
        jumps = 0;
        sword_swings = 0;
        player_kills = 0;
        mob_kills = 0;
    }

}
