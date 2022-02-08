<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 */
class ScreenshotChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new OneScreenshot(),
            new FiveScreenshots(),
            new TenScreenshots(),
            new TwentyFiveScreenshots(),
            new FiftyScreenshots(),
            new HundredScreenshots(),
        ];
    }
}
