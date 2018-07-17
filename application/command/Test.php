<?php
/**
 * Created by PhpStorm.
 * User: zgl
 * Date: 2018/7/17
 * Time: 23:51
 */

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('roma')->setDescription('Here is the remark');
    }
    protected function execute(Input $input, Output $output)
    {
        $output->writeln("Totti is King!");
    }
}