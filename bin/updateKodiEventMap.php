<?php

require_once __DIR__ . '/../vendor/autoload.php';

$kodiClient = new \Mosh\KodiCommandLineListener\KodiClient('http://mypi.home:8080');
$jsonpCommand = new \Mosh\KodiCommandLineListener\JsonPCommand('JSONRPC.Introspect');

$result = $kodiClient->execute($jsonpCommand);
$notifications = $result['result']['notifications'];

$notificationIdentifierByConstantNames = array();
foreach ($notifications as $notificationIdentifier => $info) {
    $constantName = 'EVENT_';
    $constantName .= str_replace('.', '_', strtoupper($notificationIdentifier));
    $notificationIdentifierByConstantNames[$constantName] = $notificationIdentifier;
}

ob_start();

echo '<?php', PHP_EOL; ?>
namespace Mosh\KodiCommandLineListener;

interface KodiEventMap
{
<?php foreach($notificationIdentifierByConstantNames as $constantName => $identifier) { ?>
    const <?php echo $constantName; ?> = '<?php echo $identifier; ?>';
<?php } ?>
}

<?php

$result = ob_get_clean();
$outputFile = __DIR__ . '/../src/KodiEventMap.php';
file_put_contents($outputFile, $result);

echo 'Written ' . strlen($result) . ' bytes to ' . $outputFile . PHP_EOL;