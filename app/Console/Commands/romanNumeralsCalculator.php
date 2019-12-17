<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class romanNumeralsCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:roman-numerals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Roman numerals calculator';

    /**
     * Assocc roman and arabic numbers
     *
    */

    const romanNumbers = ['I', 'V', 'X', 'L', 'C', 'D', 'M'];
    const arabicNumbers = ['1 ', '5 ', '10 ', '50 ', '100 ', '500 ', '1000 '];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expression = $this->ask('Input expression like "X + XV + XIX"');
        try {
            $expressionItems = explode(' ', $expression);
            $result = 0;
            foreach ($expressionItems as $key => $item) {
                $temp[$key] = 0;
                $arabicValues = explode(' ', str_replace(self::romanNumbers, self::arabicNumbers, $item));
                foreach ($arabicValues as $index => $arabic) {
                    if (isset($arabicValues[$index + 1]) && $arabicValues[$index + 1] > $arabic) {
                        $temp[$key] -= intval($arabic);
                    } else {
                        $temp[$key] += intval($arabic);
                    }
                } 
                if (isset($expressionItems[$key - 1])) {
                    switch ($expressionItems[$key - 1]) {
                        case '+':
                            $result += $temp[$key];
                            break;
                        case '-':
                            $result -= $temp[$key];
                            break;
                    }
                } else {
                    $result = $temp[$key];
                }
               
            }
            $thousands=(int)($result/1000);
            $result-=$thousands*1000;
            $resultToRoman=str_repeat("M",$thousands);
            $table=array(
                900=>"CM",500=>"D",400=>"CD",100=>"C",
                90=>"XC",50=>"L",40=>"XL",10=>"X",
                9=>"IX",5=>"V",4=>"IV",1=>"I");
            while($result) {
                foreach($table as $part=>$fragment) if($part<=$result) break;
                $amount=(int)($result/$part);
                $result-=$part*$amount;
                $resultToRoman.=str_repeat($fragment,$amount);
            } 
        } catch (Exception $e) {
            $this->info('Ooops, sorry...');
        }
        $this->info('Your answer: ' . $resultToRoman);
    }
}
