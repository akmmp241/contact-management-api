<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInvoicesRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $filterItems = $filter->transform($request);

        if (count($filterItems) == 0) {
            $invoices = new InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = new InvoiceCollection(Invoice::where($filterItems)->paginate()->appends($request->query()));
        }

        return response()->json(['invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BulkStoreInvoicesRequest $request)
    {
        //
    }

    public function bulkStore(BulkStoreInvoicesRequest $request): JsonResponse
    {
        $bulk = collect($request->all())->map(function ($value, $key) {
            return Arr::except($value, ['customerId', 'billedDate', 'paidDate']);
        });

//        dd($bulk->toArray());

        Invoice::insert($bulk->toArray());

//        $invoices = new InvoiceCollection(Invoice::insert($bulk->toArray()));

        return response()->json(['message' => 'success store invoices', 'invoices' => $invoices]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = new InvoiceResource($invoice);
        return response()->json(['invoice' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
