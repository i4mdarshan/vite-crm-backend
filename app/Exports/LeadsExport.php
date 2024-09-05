<?php

namespace App\Exports;

use App\Models\CustomerLeadProfile;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel;

class LeadsExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = "-leads_report.csv";
    
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
                'CompanyName' => ucwords($collection->customer_name),
                'UnderFirm' => ucwords($collection->firm->firm_name),
                'Type' => ucwords($collection->customer_type),
                'AddedBy' => ucwords($collection->employee->full_name),
                'AssignedTo' => ucwords($collection->assigned->full_name),
                'Contact1' => $collection->customer_no1,
                'Contact2' => $collection->customer_no2 ? $collection->customer_no2 : 'NA',
                'Mail1' => $collection->customer_mail ? $collection->customer_mail : 'NA',
                'Mail2' => $collection->customer_mail2 ? $collection->customer_mail2 : 'NA',
                'Address' => $collection->customer_address ? str_replace('__', ', ', $collection->customer_address) : 'NA',
                'Country' => $collection->customer_country,
                'State' => $collection->state->state_title,
                'District' => $collection->customer_district,
                'Taluka' => $collection->customer_taluka,
                'PostalCode' => $collection->customer_pin_code,
                'Website' => $collection->customer_website ? $collection->customer_website : 'NA',
                'Notes' => $collection->customer_notes ? $collection->customer_notes : 'NA',
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
            'CompanyName',
            'UnderFirm',
            'Type',
            'AddedBy',
            'AssignedTo',
            'Contact1',
            'Contact2',
            'Mail1',
            'Mail2',
            'Address',
            'Country',
            'State',
            'District',
            'Taluka',
            'PostalCode',
            'Website',
            'Notes',
            'Created',
            'Updated'
        ];
    }
}
