<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
    <form action="" method="post">
        <div style="margin-top:10px;">
            <div>
                <div style="float: left;margin-right: 10px;">Status : </div>
                <div style="float: left;margin-right:10px;">
                    <select name="status">
                        <option value="active" <?php echo (!empty($status) && $status == 'active') ? "selected='selected'" : "";?> >Active</option>
                        <option value="inactive" <?php echo (!empty($status) && $status == 'inactive') ? "selected='selected'" : "";?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div>
                <div style="float: left;margin-right: 10px;">Department : </div>
                <div style="float: left;margin-right: 10px;">
                    <select name="department">
                        <option value="">All</option>
                        <?php if(!empty($departmentInfo)) {
                            foreach($departmentInfo as $row) { 
                                if(!empty($department) && $department == $row['id']){ ?>
                                    <option value="<?php echo $row['id'];?>" selected="selected"><?php echo $row['name'];?></option>
                            <?php } else { ?>
                                    <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php } } } ?>
                    </select>
                </div>
            </div>
            <input type="submit" value="Search" name="submit">
            <div style="clear:both"></div>
        </div>
    </form>
    <div style="margin-top:20px;">
        <table width="100%" cellpadding="2" border="1">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Department Name</th>
                <th>Department Description</th>
                <th>Status</th>
            </tr>
            <?php 
                if(!empty($employeeInfo)) {
                    foreach($employeeInfo as $row) { ?>
                        <tr>
                            <td><?php echo $row['first_name'];?></td>
                            <td><?php echo $row['last_name'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['contact_number'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo ucfirst($row['status']);?></td>
                        </tr>
            <?php  }
                } else { ?>
                    <tr><td colspan="7">No Records found!</td></tr>
                <?php }?>
        </table>
    </div>
</div>

</body>
</html>