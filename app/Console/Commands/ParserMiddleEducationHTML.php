<?php

namespace App\Console\Commands;

use DOMElement;
use DOMText;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class ParserMiddleEducationHTML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsers:mid-prof-education';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Middle Education HTML';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->levels();
        $this->educationJson([4]);

        $html = file_get_contents(public_path() . "/middle_education.html");

        $crawler = new Crawler($html);

        $trs = $this->trFilter($crawler);

        $jsonFile = config('data-seed.education-areas');

        /**
         * @var int $trKey
         * @var DOMElement|DOMText $tr
         */
        foreach ($trs as $trKey => $tr) {

            $tds = $tr->getElementsByTagName('td');

            if ($tds->length === 3) {

                $json = [
                    'code' => '',
                    'okso' => $tds->item(0)->getElementsByTagName('div')->item(0)->textContent,
                    'name' => $tds->item(1)->getElementsByTagName('div')->item(0)->textContent,
                    'classifier' => [],
                ];
                /** @var DOMElement $td */
                foreach ($tds as $tdKey => $td) {
                    if ($tdKey === 2 && empty($td->getElementsByTagName('div')[0]->textContent)) {
//                    dump($tds[1]->getElementsByTagName('div')[0]->textContent);

                        $codeRange = explode('.', $tds[0]->getElementsByTagName('div')[0]->textContent);
                        $json['code'] = $codeRange[0];
                        $area = $this->educationAreas($codeRange[0]);

                        $jsonFile[$area['key']]['groups'][] = $json;
                    }

//                    $item = $jsonFile[$area['key']]['groups'] = [];
//                    $divs = $td->getElementsByTagName('div');
//                    /** @var DOMElement $div */
//                    foreach ($divs as $div) {
//                        dump(str_replace("\n", "", $div->textContent));
//                    }
//                    dd($item);

//                    $divs = $td->getElementsByTagName('div');
//
//                    /** @var DOMElement $div */
//                    foreach ($divs as $div) {
//                        dump(str_replace("\n", "", $div->textContent));
//                    }

                }
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
            dump(json_encode($jsonFile, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
//            dd('ok');
        }
//        dd($trs->count());
//        dd($trs);
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    private function trFilter(Crawler $crawler): Crawler
    {
        $tables = $crawler->filter('table')
            ->reduce(function (Crawler $node, $i) {
                return $node->children('tr')->count() > 100;
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

    private function educationJson(array $data)
    {
//        $collection = collect();
//        $collection->push($data['area']);
//        dump($collection);
//        $educationJson = $data;

        $levels = config('data-seed.test');

        $file = json_encode($levels, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//        dd($file);
//        file_put_contents(public_path() . "/levels_education.json", $file);

        return true;
    }

    private function levels()
    {
        $levels = config('data-seed.education-levels');

        $file = json_encode($levels, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);

        file_put_contents(public_path() . "/levels_education.json", $file);
    }

}
