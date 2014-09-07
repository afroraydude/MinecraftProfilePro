package pw.matrixdevuk.mcpp;

import org.bukkit.Bukkit;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.plugin.java.JavaPlugin;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.UUID;
import java.util.logging.Level;

public class Main extends JavaPlugin {

    /* Plugin to-do list
     * TODO: finish config
     *
     */

    protected static Level info = Level.INFO;
    protected static Level warn = Level.WARNING;
    protected static Level sev = Level.SEVERE;

    protected static JavaPlugin plg;

    protected static FileConfiguration conf;

    protected static UUID       uuid            = UUID.fromString("");
    protected static String     name            = "";
    protected static Integer    sword_swings    = 0;
    protected static Integer    player_kills    = 0;
    protected static Integer    mob_kills       = 0;
    protected static Integer    last_gamemode   = 0;
    protected static Integer    jumps           = 0;
    protected static Integer    deaths          = 0;
    protected static Integer    diamonds_found  = 0;
    protected static Integer    enchantments    = 0;
    protected static Integer    blocks_placed   = 0;
    protected static Integer    blocks_broken   = 0;
    protected static Boolean    is_operator     = false;
    protected static Boolean    is_banned       = false;
    protected static Object[]   player          = new Object[]{uuid, name, sword_swings, player_kills, mob_kills,
                                                               last_gamemode, jumps, deaths, diamonds_found, enchantments,
                                                               blocks_placed, blocks_broken, is_operator, is_banned};
    protected static List<Object[]> query       = new ArrayList<>();

    // MySQL stuff
    protected static String url = conf.getString("web.url");
    private String host = conf.getString("mysql.host");
    private String user = conf.getString("mysql.username");
    private String pass = conf.getString("mysql.password");
    protected static Connection connect = null;
    protected static Statement state = null;
    protected static ResultSet result = null;

    @Override
    public void onEnable() {
        log(info, "Enabling...");
        Main.plg = this;
        Main.conf = getConfig();
        getServer().getPluginManager().registerEvents(new MPPEventListener(), this);
        verifyUrl();
        connectToSqlServer();
        new MPPRunnable().runTaskLater(this, 600);      // Make the plugin push to the MySQL server every 5 minutes
        new MPPChatRunnable().runTaskLater(this, 1200); // Make the plugin tell all players the URL to the MCPP page every 10 minutes
        log(info, "Successfully enabled!");
    }

    /**
     * @see <a href="file:///C:/Users/Christian/Desktop/MySQL.txt">MySQL</a>
     */

    @Override
    public void onDisable() {
        log(info, "Disabling...");
        for (Boolean b = true; b; b = false) {
            try {
                if (result != null) {
                    result.close();
                }
                if (state != null) {
                    state.close();
                }
                if (connect != null) {
                    connect.close();
                }
            } catch (SQLException e) {
                log(warn, "SQLException thrown!");
                log(warn, e.getMessage());
            }
        }
        log(info, "Successfully disabled!");
    }

    private void verifyUrl() { // Finished
        if (!(conf.getBoolean("skip-validation"))) {
            if (url.contains("matrixdevuk") || url.isEmpty() || url.equals("")) {
                log(sev, "The URL entered in the configuration has not been set. Please change the URL to a valid value.");
                getServer().getPluginManager().disablePlugin(this);
                return;
            }
            if (!(url.endsWith("/"))) {
                log(warn, "The web server address must end in a slash. This has been corrected for you.");
                conf.set("web.url", url + "/");
            }
            if (host.contains("127.0.0.1")) {
                log(warn, "Some versions of MySQL don't accept \"127.0.0.1\" as a valid host. This has been corrected to \"localhost\" for you.");
                conf.set("mysql.host", url.replace("127.0.0.1", "localhost"));
            }
        } else {
            log(info, "Validation override has been detected. Not checking URL for errors. Continuing...");
        }
    }

    private void connectToSqlServer() {
        try {
            connect = DriverManager.getConnection(url, user, pass);
            state = connect.createStatement();
            result = state.executeQuery("SELECT VERSION()");
        } catch (SQLException e) {

        }
        getServer().getPluginManager().disablePlugin(this);
        System.exit(-1);
    }

    protected static void log(Level l, String msg) {
        Bukkit.getLogger().log(l, "MinecraftProfilePro : " + l.toString().toUpperCase() + " : " + msg);
    }

    protected static void query(String query) {
        try {
            state.executeQuery(query);
        } catch (SQLException e) {
            log(sev, "Failed to parse query! Check below stacktrace for more info!");
            e.printStackTrace();
        }
    }

    protected static Integer countRows(String tableName) throws SQLException {
        // select the number of rows in the table
        Statement stmt = null;
        ResultSet rs = null;
        Integer rowCount = -1;
        try {
            rs = connect.createStatement().executeQuery("SELECT COUNT(*) FROM " + tableName);
            // get the number of rows from the result set
            rs.next();
            rowCount = rs.getInt(1);
        } catch (SQLException ignored) {
            
        } finally {
            rs.close();
            stmt.close();
        }
        return rowCount;
    }

}
