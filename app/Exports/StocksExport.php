<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StocksExport implements FromCollection, WithMapping, WithHeadings
{
    private $fruit_id;
    private $job_card_id;
    private $childs_id = [];

    public function __construct($fruit_id, $child_ids, $job_card_id)
    {
        $this->fruit_id = $fruit_id;
        $this->job_card_id = $job_card_id;
        $this->childs_id = $child_ids;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Stock::with('fruit', 'activity', 'jobCard', 'fruit.tree')
            ->when($this->fruit_id != '', function ($query) {
                $query->where('fruit_id', $this->fruit_id);
            })
            ->where('job_card_id', $this->job_card_id)
            ->whereIn('child_activity_id', $this->childs_id)
            ->get();
    }

    public function map($stock): array
    {
        return [
            $stock->id,
            $stock->fruit->tree->tree_number,
            $stock->jobCard->job_card_number,
            $stock->quantity,
            $stock->damaged,
            $stock->issued_by,
            $stock->received_by,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Tree Number',
            'JobCard',
            'quantity',
            'Damaged',
            'Issue By',
            'Received By',
        ];
    }
}
