--TEST--
PEAR_Config->deleteChannel()
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
error_reporting(E_ALL);
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
require_once 'PEAR/ChannelFile.php';
$ch = new PEAR_ChannelFile;
$ch->setName('mychannel');
$ch->setSummary('mychannel');
$ch->setServer('mychannel');
$ch->setDefaultPEARProtocols();
$config = new PEAR_Config;
$reg = &$config->getRegistry();
$reg->addChannel($ch);
$config->removeLayer('user');
$phpunit->assertTrue($config->setChannels(array('pear.php.net', '__uri', 'mychannel')), 'set');
$config->set('php_dir', 'hi', 'user', 'mychannel');
$phpunit->assertEquals(array (
  '__channels' => 
  array (
    '__uri' => 
    array (
    ),
    'mychannel' => 
    array (
      'php_dir' => 'hi',
    ),
  ),
), $config->configuration['user'], 'raw test');

$config->deleteChannel('mychannel');

$phpunit->assertEquals(array (
  '__channels' => 
  array (
    '__uri' => 
    array (
    ),
  ),
), $config->configuration['user'], 'raw test after delete');
echo 'tests done';
?>
--EXPECT--
tests done