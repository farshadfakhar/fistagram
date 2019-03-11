<html>
    <head>
        <title>Instagram</title>
    </head>
    <body>
        <div class="activity">
            <table>
                <tr>
                    <td>ش ک</td>
                    <td>فعالیت</td>
                    <td>جزئیات</td>
                    <td>تاریخ</td>
                </tr>
                <?php
                $table = '';
                foreach($activity as $a){
                    $table .= "
                    <tr>
                        <td>$a->account_id</td>
                        <td>$a->activity</td>
                        <td>$a->details</td>
                        <td>$a->created_at</td>
                    </tr>
                    ";
                }
                echo $table;
                ?>
            </table>
        </div>
    </body>
</html>