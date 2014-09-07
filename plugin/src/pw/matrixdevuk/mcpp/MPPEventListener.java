package pw.matrixdevuk.mcpp;

import org.bukkit.Material;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.block.BlockBreakEvent;
import org.bukkit.event.block.BlockPlaceEvent;
import org.bukkit.event.entity.PlayerDeathEvent;
import org.bukkit.event.player.PlayerInteractEvent;
import org.bukkit.event.player.PlayerLoginEvent;
import org.bukkit.event.player.PlayerMoveEvent;
import org.bukkit.inventory.ItemStack;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.UUID;

import static pw.matrixdevuk.mcpp.Main.*;

public class MPPEventListener implements Listener {

    /************************\
     *  | Handled Events |  *
     *  `----------------`  *
     * Sword swings         *
     * Player name          *
     * Jumps                *
     * Last seen            *
    \************************/

    /************************\
     * | Unhandled Events | *
     * `------------------` *
     * Deaths               *
     * Op status            *
     * Last gamemode        *
     * Ban status           *
     * Player kills         *
     * Mob kills            *
     * Blocks broken        *
     * Blocks placed        *
     * Diamond ore mined    *
     * Times enchanted      *
    \************************/

    private void findPlayerArray(Player p) {
        for (Object id : player) {
            if (id instanceof UUID) {
                if (id.equals(p.getUniqueId())) {

                }
            }
        }
    }

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

    @EventHandler
    public void onLogin(PlayerLoginEvent evt) {
        { // Query one
            Player p = evt.getPlayer();
            player[0] = p.getUniqueId();
            query("SELECT COUNT(`uuid`) FROM `players` WHERE `uuid`='" + p.getUniqueId() + "'");
            if (countRows("players")==0){
                query("INSERT INTO `players`(`uuid`,`name`,`last_seen`) VALUES('" + p.getUniqueId() + "', '" + p.getName() +"', NOW())");
            }
            player[1] = p.getName();
            for (int i = 2; i < 5; i++) {
                player[i] = 0;
            }
            // player[5] = /* Get MySQL's current value here */;
            player[6] = 0;
        }
        { // Query two

        }
    }

    @EventHandler
    public void onSwing(PlayerInteractEvent evt) {
        Player p = evt.getPlayer();
        if (p.getItemInHand().isSimilar(new ItemStack(Material.WOOD_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.STONE_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.IRON_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.GOLD_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.DIAMOND_SWORD))) {
            sword_swings += 1;
        }
    }

    @EventHandler
    public void onJump(PlayerMoveEvent evt) {
        if (evt.getPlayer().getVelocity().getY() > 0.4) {

            jumps += 1;
        }
    }

    @EventHandler
    public void onDeath(PlayerDeathEvent evt) {
        Player victim = evt.getEntity().getPlayer();
        if (evt.getEntity().getKiller() != null) {
            // The victim was killed by a player!
            Player killer = evt.getEntity().getKiller();
        } else {
            // The victim was killed by a mob/natural causes!
            // TODO: Add +1 to the victim's `deaths` key!
        }
    }

    @EventHandler
    public void onBlockBreak(BlockBreakEvent evt) {
        Player p = evt.getPlayer();
        // TODO: Add +1
        if (evt.getBlock().getType() == Material.DIAMOND_ORE) {
            // TODO: Add +1 to
        }
    }

    @EventHandler
    public void onBlockPlace(BlockPlaceEvent evt) {
        Player p = evt.getPlayer();
    }

}
