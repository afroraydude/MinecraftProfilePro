package pw.matrixdevuk.mcpp;

import org.bukkit.Bukkit;
import org.bukkit.ChatColor;
import org.bukkit.scheduler.BukkitRunnable;

public class MPPChatRunnable extends BukkitRunnable {

    @Override
    public void run() {
        Bukkit.getServer().broadcastMessage(ChatColor.GRAY + "Interested in how you've been performing? Visit " +
                                            ChatColor.GREEN + Main.url + ChatColor.GRAY + " to see your stats!");
    }

}
