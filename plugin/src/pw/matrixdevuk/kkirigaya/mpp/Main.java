package pw.matrixdevuk.kkirigaya.mpp;

import org.bukkit.Bukkit;
import org.bukkit.plugin.java.JavaPlugin;

import java.util.ArrayList;
import java.util.List;
import java.util.UUID;
import java.util.logging.Level;

public class Main extends JavaPlugin {

    protected static Level info = Level.INFO;
    protected static Level warn = Level.WARNING;
    protected static Level sev = Level.SEVERE;

    protected static void log(Level l, String msg) {
        Bukkit.getLogger().log(l, msg);
    }

    protected static List<Object>   queue           = new ArrayList<>();
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

    @Override
    public void onEnable() {
        log(info, "MinecraftProfilePro : INFO : Enabling...");
        getServer().getPluginManager().registerEvents(new MPPEventListener(), this);
        new MPPRunnable().runTaskLater(this, 600); // Start up the
        try {
            /* TODO: Insert MySQL hooking here, and throw an exception if it fails */
        } catch (Exception e) {
            log(sev, "MinecraftProfilePro : SEVERE : Failed to connect to the MySQL server! Do you have a MySQL server running?");
            getServer().getPluginManager().disablePlugin(this);
            return;
        }
        log(info, "MinecraftProfilePro : INFO : Successfully enabled!");
    }

    @Override
    public void onDisable() {
        log(info, "MinecraftProfilePro : INFO : Disabling...");
        for (Boolean b = true; b; b = false) {
            /* if ([plugin is shutting down from another plugin]) break; */
            try {
            /* TODO: Do whatever you need to do for MySQL cleanup */
            } catch (Exception e) {
                log(sev, "MinecraftProfilePro : SEVERE : Failed to clean up the MySQL server!");
                return;
            }
        }
        log(info, "MinecraftProfilePro : INFO : Successfully disabled!");
    }



}
