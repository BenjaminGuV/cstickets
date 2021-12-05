<?php

    //$path_browser_client = NWMJ_NEWMOJI__PLUGIN_DIR . "libs/NWMJBrowserClient.php";

    header("Content-type:application/pdf");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename='downloaded.pdf'");

// The PDF source is in original.pdf
readfile("original.pdf");

?>