<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 12/1/18
 * Time: 4:44 PM
 */
$this->pageTitle = 'Unauthorized action';
?>
<input id="unauth" type="text" name="deniedactions" value="<?php if(isset($deny)){ echo $deny; } ?>" hidden>
