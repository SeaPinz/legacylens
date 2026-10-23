<?php
// 注意: LegacyLens の動作確認用に、意図的に脆弱・古い書き方をしたサンプルです。実行・流用しないでください。
class Customer
{
    var $name;
    function Customer($name)
    {
        $this->name = $name;
    }
}
