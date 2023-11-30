<?php

namespace App\Traits;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

trait HelperTrait
{
    private function servicePath(): string
    {
        return app_path() . "\Services";
    }

    private function consoleOutput($message = "", $type = null): void
    {
        $output = new ConsoleOutput();

        switch($type) {
            case "error":
                $style = new OutputFormatterStyle("white", "red", ['bold']);
                $output->getFormatter()->setStyle("error", $style);
                $output->writeln("\n<error> Error </error> \n\n $message");

                break;

            case "success":
                $style = new OutputFormatterStyle("green", null, ['bold']);
                $output->getFormatter()->setStyle("success", $style);
                $output->writeln("\n<success> $message </success>");

                break;
            default:
        }

    }
}
