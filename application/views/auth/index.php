<html>
    <head>        
    </head>
    <body>
        <h1 style="text-align: center;">Change Password</h1>
        <form method="POST" action="<?php echo base_url().'auth/reset_pwd' ; ?>">
            <input type="hidden" name="accesstoken" value="<?php echo $request_token; ?>">
            <table style="border:1px solid #ccc; font-family:arial,helvetica,sans-serif; font-size:12px; margin:0 auto; max-width:600px; padding:20px; text-align:center; width:550px;">

                <tr>
                    <td>New Password:</td>

                    <td><input type="password" name="newpwd"></td>

                </tr>
                <tr>
                    <td>Confirm Password:</td>

                    <td><input type="password" name="confirmpwd"></td>

                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        <input type="submit" name="submit_btn" value="Submit">
                    </td>

                </tr>

            </table>

        </form>
    </body>
</html>