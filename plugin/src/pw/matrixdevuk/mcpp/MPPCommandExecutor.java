package pw.matrixdevuk.mcpp;

import org.bukkit.command.Command;
import org.bukkit.command.CommandSender;

public class MPPCommandExecutor {

    public boolean onCommand(CommandSender s, Command cmd, String alias, String[] args) {
        if (cmd.getName().equalsIgnoreCase("push")) {

        } else if (cmd.getName().equalsIgnoreCase("wipe")) {
            /* TODO
             * 1. Get current values of everyone's stats
             * 2. Set each one to zero
             * 3. Push back to the main server
             */
        } else if (cmd.getName().equalsIgnoreCase("pwipe")) {

        }
        return false;
    }

}
