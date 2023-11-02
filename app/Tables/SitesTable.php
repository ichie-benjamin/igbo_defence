<?php

namespace App\Tables;

use App\Models\Site;
use App\Models\Software;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;

class SitesTable extends AbstractTable
{

    public function __construct()
    {
        //
    }

    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Site::query();
    }

    public function configure(SpladeTable $table)
    {

        $table->defaultSort('id')
            ->withGlobalSearch(columns: ['license','domain','software_id','buyer_name'])
            ->column(key: 'license', label : 'License', sortable: true)
            ->column(key: 'domain', sortable: true)
            ->column('software_id', sortable: true)
            ->column('buyer_name', sortable: true)
            ->column('status', sortable: true)
            ->column('created_at', sortable: true, exportAs: false)
            ->selectFilter(
                key: 'software_id',
                options: Software::pluck('software_id','name')->toArray(),
                label: 'Software',
                noFilterOption: true,
                noFilterOptionLabel: 'All Software')
            ->column(label: 'Actions')
            ->export(
                label: 'CSV export',
                filename: 'sites.csv',
                type: Excel::CSV
            )
            ->paginate(15);

            // ->bulkAction()

    }
}
