<?php

namespace App\Helpers;


class FrontPageQuotes
{
    protected static $quotes
        = [
            ['Excited!', 'NJUJB Fans'],
            ['Visit JB once a day, keep deadlines away.', 'NJUJB Idiom'],
            ['All assignments and no JB make Jack a dull boy.', 'NJUJB Idiom'],
            ['Love me, love my deadlines.', 'NJUJB Idiom'],
            ['Library or lab, dormitory is best.', 'NJUJB Idiom'],
            [
                'A bad students quarrels with his DDL management tools.',
                'NJUJB Idiom',
            ],
            ['Never too late to catch up with DDLs.', 'NJUJB Idiom'],
            ['Deadline is the ultimate power.', 'NJUJB Idiom'],
            ['Assignment managing, redefined.', 'NJUJB Prompt (VSCode)'],
            ['Love less deadlines? We do too.', 'NJUJB Prompt (Laravel)'],
            [
                '...one of the most highly regarded and expertly designed DDL tools in the world.',
                'NJUJB Prompt (Boost. C++)',
            ],
            [
                'Get more done with the new JB Online.',
                'NJUJB Prompt (Google Chrome)',
            ],
            [
                'Whichever courses you study, there is a JB group to match.',
                'NJUJB Prompt (JetBrains)',
            ],
            [
                'An assignment manager, an assignment tracker.',
                'NJUJB Prompt (Typora)',
            ],
            [
                'FAST, RELIABLE, AND SECURE ASSIGNMENT TRACKING.',
                'NJUJB Prompt (YarnPKG)',
            ],
        ];

    public static function getQuote()
    {
        $quote = self::$quotes[array_rand(self::$quotes, 1)];

        return "<blockquote>"
            ."    <h3 class=\"h2 mb-4\">".$quote[0]."</h3>"
            ."    <footer>"
            ."        —"
            ."        <cite class=\"text-lg\">"
            ."            ".$quote[1]
            ."        </cite>"
            ."    </footer>"
            ."</blockquote>";
    }
}