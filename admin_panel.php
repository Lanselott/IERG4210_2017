<?php
  include_once('lib/db.inc.php');
  ini_set('display_errors',1);
?>

<!DOCTYPE html>
<fieldset>
  <legend>New Product</legend>
  <form id="prod_insert" method="post" action="admin-process.php?action=<?php echo ($action='prod_insert');?>" enctype="multipart/form-data">
    <label for="prod_catid">Category *</label>
    <div>
      <select id="prod_catid" name="catid">
        <?php
	  show_categories(); 
	?>
      </select>
    </div>

    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
    </div>
    <label for="prod_price">Price *</label>
    <div>
      <input id="prod_price" type="text" name="price" required="true"
      pattern="^[0-9]+$"/>
    </div>
    <label for="prod_description">Description *</label>
    <div>
      <input id="prod_description" type="text" name="description" required="true"/>
    </div>
    <label for="prod_name">Image *</label>
    <div>
      <input type="file" name="file" required="true" accept="image/jpeg" />
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>


<fieldset>
  <legend>Delete Product</legend>
  <form id="prod_delete" action="admin-process.php?action=<?php echo ($action='prod_delete'); ?>" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>

<fieldset>
  <legend>Update Product</legend>
  <form id="prod_update" action="admin-process.php?action=<?php echo ($action='prod_update');?>" method="POST" enctype="multipart/form-data">
    <label for="prod_catid">Category *</label>
    <div>
      <select id="prod_catid" name="catid">
      <?php 
        show_categories();
      ?>
      </select>
    </div>

    <label for="prod_name">Name *</label>
    <div>
      <input id="prod_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
    </div>
    <label for="prod_price">Price *</label>
    <div>
      <input id="prod_price" type="text" name="price" required="true"
      pattern="^[0-9]+$"/>
    </div>
    <label for="prod_description">Description *</label>
    <div>
      <input id="prod_description" type="text" name="description" required="true"/>
    </div>
    <label for="prod_name">Image *</label>
    <div>
      <input type="file" name="file" accept="image/jpeg" />
    </div>
    <input type="hidden" id="prod_edit_pid" name="pid" />
    <input type="submit" value="Submit" />

  </form>
</fieldset>

<fieldset>
  <legend>Rename categories</legend>
  <form id="cate_rename" action="admin-process.php?action=<?php echo ($action='cate_rename');?>" method="POST" enctype="application/x-www-form-urlencoded">
    <label for="cate_catid">Old Name *</label>
    <div>
      <input id="cate_oldname" type="text" name="oldname" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <label for="cate_newname">New Name *</label>
    <div>
      <input id="cate_newname" type="text" name="newname" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>

<fieldset>
  <legend>Add categories</legend>
  <form id="cate_add" action="admin-process.php?action=<?php echo ($action='cate_add');?>" method="POST"
  enctype="application/x-www-form-urlencoded">

    <label for="cate_newname">Name *</label>
    <div>
      <input id="cate_newname" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>


<fieldset>
  <legend>Delete categories</legend>
  <form id="cate_delete" action="admin-process.php?action=<?php echo ($action='cate_delete');?>" method="POST"
  enctype="application/x-www-form-urlencoded">
    <label for="cate_catid">Category *</label>
    <div>
      <input id="cate_name" type="text" name="name" required="true"
      pattern="^[\w\- ]+$"/>
    </div>

    <input type="submit" value="Submit" />

  </form>
</fieldset>
<?php
function show_categories() {
         $db = ierg4210_DB();
	foreach($db ->query('SELECT catid,name FROM categories') as $row)
	{
	    unset($catid,$name);
            $catid = $row['catid'];
            $name = $row['name'];
            echo '<option value="'.$catid.'">'.$name.'</option>';
	} 
}
?>
