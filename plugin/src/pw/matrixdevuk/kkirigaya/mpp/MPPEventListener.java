package pw.matrixdevuk.kkirigaya.mpp;

import org.bukkit.Material;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.entity.PlayerDeathEvent;
import org.bukkit.event.player.PlayerInteractEvent;
import org.bukkit.event.player.PlayerMoveEvent;
import org.bukkit.inventory.ItemStack;

import static pw.matrixdevuk.kkirigaya.mpp.Main.*;

public class MPPEventListener implements Listener {

    /************************\
     *     | Handled: |     *
     *     `----------`     *
     * Sword swings         *
     * Jumps                *
     * Last seen            *
    \************************/

    /************************\
     *  | To be handled: |  *
     *  `----------------`  *
     * Deaths               *
     * Op status            *
     * Last gamemode        *
     * Ban status           *
     * Player kills         *
     * Mob kills            *
     * Blocks mined         *
     * Diamond ore mined    *
     * Times enchanted      *
    \************************/

    // TODO: Add an array called 'queue' and then each event, push +1 to queue->player->{event_key}


    @EventHandler
    public void onSwing(PlayerInteractEvent evt) {
        Player p = evt.getPlayer();
        if (p.getItemInHand().isSimilar(new ItemStack(Material.WOOD_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.STONE_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.IRON_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.GOLD_SWORD)) || p.getItemInHand().isSimilar(new ItemStack(Material.DIAMOND_SWORD))) {
            sword_swings += 1;
            /* TODO: The player's swinging a sword! Add +1 to the `sword_swings` key! */
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
        if (evt.getDeathMessage().contains("")) {
            // The victim was killed by a player!
            Player killer = evt.getEntity().getKiller();
        } else {
            // The victim was killed by a mob/natural causes!
            /* TODO: Add +1 to the victim's `deaths` key! */
        }
    }
}
