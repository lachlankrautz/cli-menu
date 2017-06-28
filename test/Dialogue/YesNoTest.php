<?php

namespace PhpSchool\CliMenuTest\Dialogue;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\MenuItem\SelectableItem;
use PhpSchool\CliMenu\MenuStyle;
use PhpSchool\CliMenu\Terminal\TerminalInterface;
use PHPUnit_Framework_TestCase;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class YesNoTest extends PHPUnit_Framework_TestCase
{

    public function testYesNoIsNoByDefault()
    {
        $terminal = $this->createMock(TerminalInterface::class);

        $terminal->expects($this->any())
            ->method('isTTY')
            ->willReturn(true);

        $terminal
            ->method('getKeyedInput')
            ->will($this->onConsecutiveCalls(
                'enter',
                'enter'
            ));

        $terminal->expects($this->any())
            ->method('getWidth')
            ->willReturn(50);

        $style = $this->getStyle($terminal);

        $confirmed = false;
        $item = new SelectableItem('Item 1', function (CliMenu $menu) use (&$confirmed) {
            $menu->yesNo('Confirm???', function ($result) use (&$confirmed) {
                $confirmed = $result;
            })
            ->display();

            $menu->close();
        });

        $this->expectOutputString(file_get_contents($this->getTestFile()));

        $menu = new CliMenu('PHP School FTW', [$item], $terminal, $style);
        $menu->open();

        self::assertFalse($confirmed);
    }

    public function testYesNoSelectYes()
    {
        $terminal = $this->createMock(TerminalInterface::class);

        $terminal->expects($this->any())
            ->method('isTTY')
            ->willReturn(true);

        $terminal
            ->method('getKeyedInput')
            ->will($this->onConsecutiveCalls(
                'enter',
                'left',
                'enter'
            ));

        $terminal->expects($this->any())
            ->method('getWidth')
            ->willReturn(50);

        $style = $this->getStyle($terminal);

        $confirmed = false;
        $item = new SelectableItem('Item 1', function (CliMenu $menu) use (&$confirmed) {
            $menu->yesNo('Confirm???', function ($result) use (&$confirmed) {
                $confirmed = $result;
            })
                ->display();

            $menu->close();
        });

        $this->expectOutputString(file_get_contents($this->getTestFile()));

        $menu = new CliMenu('PHP School FTW', [$item], $terminal, $style);
        $menu->open();

        self::assertTrue($confirmed);
    }

    /**
     * @return string
     */
    private function getTestFile()
    {
        return sprintf('%s/../res/%s.txt', __DIR__, $this->getName());
    }

    /**
     * @param TerminalInterface $terminal
     * @return MenuStyle
     */
    private function getStyle(TerminalInterface $terminal)
    {
        return new MenuStyle($terminal);
    }
}
