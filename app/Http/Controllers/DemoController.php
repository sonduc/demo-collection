<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function demo1(Request $request)
    {
        $data = collect($request->all()['products'])->filter(function ($item) {
            return in_array($item['product_type'], ['Wallet', 'Lamp']);
        })->flatMap(function ($item) {
            return $item['variants'];
        })->sum('price');
        return $this->respondSuccess($data);
    }

    public function demo2()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];
        $shiftIds = collect($shifts)->map(function ($shift) {
            return collect(explode('_', $shift))->last();
        });
        return $this->respondSuccess($shiftIds);
    }

    public function demo3()
    {
        $data = [
            'Opening brace must be the last content on the line',
            'Closing brace must be on a line by itself',
            'Each PHP statement must be on a line by itself',
        ];
        $result = collect($data)->map(function ($message) {
            return "- {$message}\n";
        })->implode('');
        return $this->respondSuccess($result);
    }

    public function demo4($postId)
    {
        $data = [
            17,
            32,
            'recipes',
            11,
            'kitchen'
        ];
        $post = Post::find($postId);
        $tagIds = $this->normalizeTagsToIds($data);
        $post->tags()->sync($tagIds);
        return view('posts.index');
    }

    private function normalizeTagsToIds($tags)
    {
        return collect($tags)->map(function ($nameOrId) {
            return $this->normalizeTagToId($nameOrId);
        });
    }
    private function normalizeTagToId($nameOrId)
    {
        if (is_numeric($nameOrId)) {
            return $nameOrId;
        }
        return Tag::create(['name' => $nameOrId])->id;
    }

    public function demo5()
    {
        $lastYear = [
            2976.50, // Jan
            2788.84, // Feb
            2353.92, // Mar
            3365.36, // Apr
            2532.99, // May
            1598.42, // Jun
            2751.82, // Jul
            2576.17, // Aug
            2324.87, // Sep
            2299.21, // Oct
            3483.10, // Nov
            2245.08, // Dec
        ];
        $thisYear = [
            3461.77,
            3665.17,
            3210.53,
            3529.07,
            3376.66,
            3825.49,
            2165.24,
            2261.40,
            3988.76,
            3302.42,
            3345.41,
            2904.80,
        ];

        return collect($thisYear)->zip($lastYear)->map(function ($thisAndLast) {
            return $thisAndLast[0] - $thisAndLast[1];
        })->toArray();
    }

    public function demo6()
    {
        $employees = [
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane@example.com'
            ],
            [
                'name' => 'Dave',
                'department' => 'Marketing',
                'email' => 'dave@example.com'
            ],
        ];
        $emailLookup = collect($employees)->reduce(function ($emailLookup, $employee) {
            $emailLookup[$employee['email']] = $employee['name'];
            return $emailLookup;
        }, []);
        return $this->respondSuccess($emailLookup);
    }

    public function demo7()
    {
        $emailLookup = collect([
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane@example.com'
            ],
            [
                'name' => 'Dave',
                'department' => 'Marketing',
                'email' => 'dave@example.com'
            ],
        ])->map(function ($employee) {
            return [$employee['email'], $employee['name']];
        })->toAssoc();
        return $this->respondSuccess($emailLookup);
    }

    public function demo8()
    {
        $data = [
            [
                'name' => 'Jane',
                'occupation' => 'Doctor',
                'email' => 'jane@example.com',
            ],
            [
                'name' => 'Bob',
                'occupation' => 'Plumber',
                'email' => 'bob@example.com',
            ],
            [
                'name' => 'Mary',
                'occupation' => 'Dentist',
                'email' => 'mary@example.com',
            ],
        ];
        $result = collect($data[0])->keys()->reduce(function ($itemLookup, $item) use ($data) {
            $other = collect($data)->pluck($item)->all();
            $itemLookup[$item] = $other;
            return $itemLookup;
        }, []);

        return $this->respondSuccess($result);
    }

    public function demo9()
    {
        $scores = collect([
            ['score' => 76, 'team' => 'A'],
            ['score' => 62, 'team' => 'B'],
            ['score' => 82, 'team' => 'C'],
            ['score' => 86, 'team' => 'D'],
            ['score' => 91, 'team' => 'E'],
            ['score' => 67, 'team' => 'F'],
            ['score' => 67, 'team' => 'G'],
            ['score' => 82, 'team' => 'H'],
        ]);
        $rankedScores = $scores->sortByDesc('score')->values()
            ->zip(range(1, $scores->count()))
            ->map(function ($scoreAndRank) {
                list($score, $rank) = $scoreAndRank;
                return array_merge($score, [
                    'rank' => $rank
                ]);
            });
//        dd($rankedScores);
        $group_score = $rankedScores->groupBy('score')
            ->map(function ($tiedScores) {
                return $this->apply_min_rank($tiedScores);
            })
            ->collapse()
            ->sortBy('rank');
//        dd($group_score);
        return $this->respondSuccess($group_score->toArray());
    }

    function apply_min_rank($tiedScores)
    {
        $lowestRank = $tiedScores->pluck('rank')->min();
        return $tiedScores->map(function ($rankedScore) use ($lowestRank) {
            return array_merge($rankedScore, [
                'rank' => $lowestRank
            ]);
        });
    }

}
