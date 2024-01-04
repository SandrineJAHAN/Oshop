<h1>liste des utilisateurs</h1>


<table>
    <tr> 

        <?php
        foreach ($users as $user) : ?>
            <td>
                <?= $user->getEmail(); ?>

            </td>
   
<?php endforeach ?>
</tr>
    <tr> 
    <?php
    foreach ($users as $user) : ?>
        <td>
            <?= $user->getRole(); ?>

        </td>
    <?php endforeach ?>
    </tr>
</table>