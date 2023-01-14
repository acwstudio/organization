<?php

namespace App\Console\Commands;

use DOMElement;
use DOMNodeList;
use DOMNodeList as DOMNodeListAlias;
use DOMText;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParserEducationAggregatedGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsers:edu-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Education Aggregated Groups';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $middleCrawler = new Crawler(file_get_contents(public_path() . "/middle_education.html"));
        $highCrawler = new Crawler(file_get_contents(public_path() . "/high_education.html"));

        $jsonFile = config('data-seed.education-areas');

        $newCrawler = new Crawler();
        $newCrawler->addHtmlContent($middleCrawler->html() . $highCrawler->html());

        $trs = $this->trFilter($newCrawler);

        /**
         * @var int $trKey
         * @var DOMElement|DOMText $trs
         */
        /** @var DOMElement $tr */
        foreach ($trs as $trKey => $tr) {
            /** @var DOMElement|DOMText $td */
            $tds = $tr->getElementsByTagName('td');

            if ($tds->length === 3) {

                foreach ($tds as $tdKey => $td) {

                    if ($tdKey === 2 && empty($td->getElementsByTagName('div')[0]->textContent)) {

                        $codeRange = explode('.', $tds[0]->getElementsByTagName('div')[0]->textContent);

                        $json = [
                            'code' => $codeRange[0],
                            'okso' => $tds->item(0)->getElementsByTagName('div')->item(0)->textContent,
                            'name' => $tds->item(1)->getElementsByTagName('div')->item(0)->textContent,
                            'classifier' => [],
                        ];

                        $area = $this->educationAreas($codeRange[0]);
                        $jsonFile[$area['key']]['groups'][$codeRange[0]] = $json;
                    }

//                    else if ($tdKey === 1 && !empty($td->getElementsByTagName('div')[0]->textContent)) {
//                        dump($td->getElementsByTagName('div')[0]->textContent);
//                        $codeRange = explode('.', $tds[0]->getElementsByTagName('div')[0]->textContent);
//                        $area = $this->educationAreas($codeRange[0]);
//
//                        if (count($codeRange) > 1 ){
//                            $json1 = [
//                                'code' => $codeRange[2],
//                                'okso' => $tds->item(0)->getElementsByTagName('div')->item(0)->textContent,
//                                'name' => $tds->item(1)->getElementsByTagName('div')->item(0)->textContent,
//                            ];
//                        }
//
//
//
////                        dump($codeRange);
//                        if (count($codeRange) > 1) {
//                            $jsonFile[$area['key']]['groups'][$codeRange[0]]['classifier'][$codeRange[2]] = $json1;
//                        }
//
//                    }
                }
//                dd($jsonFile);
            }

            if ($tds->length === 2) {
                /** @var DOMElement $td */
                foreach ($tds as $td) {
                    $divs = $td->getElementsByTagName('div');
                    /** @var DOMElement $div */
                    foreach ($divs as $div) {
//                        dd($div->textContent);
                    }
//                    dd($td->getElementsByTagName('div')[0]->textContent);
                }

//                $jsonFile['3']['groups'][] =
//                dump($tds->item(1)->getElementsByTagName('div')->item(0)->textContent);

            }

        }
//        dd(json_encode($jsonFile, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        /**
         * @var int $trKey
         * @var DOMElement|DOMText $tr
         */
        foreach ($trs as $trKey => $tr) {
            $tds = $tr->getElementsByTagName('td');
//            dd($tds);
            /** @var DOMElement|DOMText $td */
            foreach ($tds as $td) {
//                dump($td->getElementsByTagName('div')[0]->textContent);
            }
        }

        return Command::SUCCESS;
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    private function trFilter(Crawler $crawler): Crawler
    {
        $tables = $crawler->filter('table')
            ->reduce(function (Crawler $node, $i) {
                return $node->children('tr')->count() > 30;
            });

        $trs = $tables->filter('tr')
            ->reduce(function (Crawler $node, $i) {
                if ($node->children('td')->count() === 3) {
                    return $node->children('td')->first()->children('div')->count() !== 2;
                }
            })->reduce(function (Crawler $node, $i) {
                return $node->children('td')->count() !== 1;
            });

        return $trs;
    }

    /**
     * @param string $codeRange
     * @return array|null
     */
    private function educationAreas(string $codeRange): ?array
    {
        $areas = config('data-seed.education-areas');
        $area1 = null;
        foreach ($areas as $key => $area) {
            $arr = [];
            $test = explode('-', $area['group-spacing']);
            $num = (int)$test[1] - (int)$test[0];

            for ($i = 0; $i <= $num; $i++) {
                $arr[] = (int)$test[0] + $i;
            }

            if (in_array($codeRange, $arr)) {
                $area1 = [
                    'key' => $key,
                    'name' => $area['name']
                ];
            }

        }
//        dd($area1);
        return $area1;
    }
}
