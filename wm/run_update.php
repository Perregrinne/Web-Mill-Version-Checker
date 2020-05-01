<?php 
    //I could use some reusable function to copy/replace all updated
    //files but this way is more direct and has less room for errors
    //if you ask me. Whoever/Whatever puts together the update files
    //in the future must be aware of which files get deleted, added,
    //or replaced. In the update, updateTarget.php gets overwritten,
    //updateTarget2.php gets replaced, updateTarget3.php is deleted,
    //and updateTarget4.php is deleted. These are testing files that
    //demonstrate that this works at all. They are not real WM files

    /*
    * Notes and considerations while I was writing this .php script:
    * If everything is done "manually" by the script, then it really
    * shouldn't matter if all updated files are in their destination
    * directories inside the update zip. The update script will just
    * know what needs to get done and where everything already goes.
    * In future, all files can just go in wmupdate's root directory.
    * Also, all of these comments I've been writing seem to line up.
    */

    //The locations of the update files and the files to be updated:
    $tmp = $argv[1] . '/tmp/wm'; //$_SERVER['DOCUMENT_ROOT'] doesn't
    $current = $argv[1] . '/php'; //work here, so it gets passed in.

    //updateTarget.php: Replace
    copy($tmp . '/updateTarget.php', $current . '/updateTarget.php');
    //updateTarget2.php: Replace
    copy($tmp . '/admin/updateTarget2.php', $current . '/admin/updateTarget2.php');
    //updateTarget3.php: Delete
    //I shouldn't even bother making an updateTarget3.php next time.
    //I kind of thought this would be done a little bit differently.
    if(file_exists($current . '/development/updateTarget3.php'))
    {
        unlink($current . '/development/updateTarget3.php');
    }
    //updateTarget4.php: Create
    mkdir($current . '/development/updateTarget4');
    copy($tmp . '/development/updateTarget4/updateTarget4.php', $current . '/development/updateTarget4/updateTarget4.php');

    //Update the new version number in /admin/config.php:
    //Open the config file and read it in:
    $conf = file_get_contents($current . '/admin/config.php');
    //Perform the search and replace on the line with $VERSION number
    $conf_updated = preg_replace('([$]VERSION = \'?"?[0-9.]+\'?"?;)', '$VERSION = \'0.1.1\';', $conf);

    //Write it back and close the file:
    file_put_contents($current . '/admin/config.php', $conf_updated);

    //And finally, import functions.php to call delete_dir() on the /tmp folder
    include_once($current . '/functions.php');
    delete_dir($argv[1] . '/tmp');