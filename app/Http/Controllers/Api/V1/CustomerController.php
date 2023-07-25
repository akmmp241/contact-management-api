<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DeleteCustomerRequest;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request);

        $includeInvoices = $request->query('includeInvoices');
        $customersModel = Customer::where($filterItems);

        if ($includeInvoices) {
            $customersModel = $customersModel->with('invoices');
        }

        $customers = new CustomerCollection($customersModel->paginate()->appends($request->query()));

        return response()->json(['customers' => $customers]);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = new CustomerResource(Customer::create($request->all()));

        return response()->json([
            'message' => 'success store data',
            'customer' => $customer
        ]);
    }

    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        $customer = !$includeInvoices
            ? new CustomerResource($customer) :
            new CustomerResource($customer->loadMissing('invoices'));

        return response()->json(['customer' => $customer], 200);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        $customer = new CustomerResource($customer);
        return response()->json([
            'message' => 'success update data',
            'customer' => $customer
        ]);
    }

    public function destroy(DeleteCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->delete();
        return response()->json(['message' => 'success remove data']);
    }
}
