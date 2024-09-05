<?php

namespace App\Exports;

use App\Models\CustomersCollections;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel;

class CustomersCollectionsExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = "-collections_report.csv";
    
    /**
    * Optional Writer Type
    */
    private $writerType = Excel::CSV;   

     /**
    * Optional headers
    */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    /**
     * Collection to be passed in csv
     */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Transform the data before exporting
        $this->data->transform(function ($collection) {
            return [
                'Employee' => ucwords($collection->collected_by_person_name),
                'CustomerName' => ucwords($collection->customer->customer_name),
                'ModeOfPayment' => $collection->mode_of_payment,
                'CollectedBy' => ucwords($collection->collected_by_person_name),
                'CollectedFrom' => ucwords($collection->raised_by->contact_person_name),
                'AmountReceived' => $collection->money_received,
                'AmountReceivedDate' => date('d-m-Y', strtotime($collection->money_received_date)),
                'AmountPending' => $collection->money_pending,
                'AmountPendingDate' => $collection->money_pending_date ? date('d-m-Y', strtotime($collection->money_pending_date)) : 'NA',
                'Status' => $collection->status,
                'Created' => date('d-m-Y', strtotime($collection->created)),
                'Updated' => date('d-m-Y', strtotime($collection->updated))
            ];
        });
        return collect($this->data);
    }

    public function headings(): array
    {
        // Custom column names
        return [
            'Employee',
            'CustomerName',
            'ModeOfPayment',
            'CollectedBy',
            'CollectedFrom',
            'AmountReceived',
            'AmountReceivedDate',
            'AmountPending',
            'AmountPendingDate',
            'Status',
            'Created',
            'Updated'
        ];
    }
}
