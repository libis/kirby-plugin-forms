<p style="font-family: Arial, sans-serif; font-size: 16px;">
  Beste collega,<br><br>
  Er is zojuist een nieuw formulier ingediend via de website. Hieronder vind je de details die de gebruiker heeft ingevuld:<br><br>
</p>

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Arial, sans-serif; font-size: 14px;">
  <tr>
    <td style="font-size: 18px; font-weight: bold; padding-bottom: 10px;">Gegevens</td>
  </tr>
  <tr>
    <td>
      <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border-collapse: collapse;">
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td style="font-weight: bold; width: 30%;"><?= ucfirst($key) ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
</table>

<p style="font-family: Arial, sans-serif; font-size: 16px;">
  <br>
  Indien nodig kan je de gebruiker contacteren via het ingevulde mailadres hierboven. Gelieve niet niet te antwoorden op deze mail deze is niet gekoppeld aan de mail van de gebruiker.<br><br>
  Met vriendelijke groeten,<br>
  ... team
</p>